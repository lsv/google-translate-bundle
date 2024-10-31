<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate;

use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;
use Lsv\GoogleTranslationBundle\Translate\Model\DetectModel;
use Lsv\GoogleTranslationBundle\Translate\Model\TranslateModel;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;

final readonly class GoogleTranslator implements TranslatorInterface
{
    private const string TEXT_DELIMITER = '#.#.#';

    public function __construct(
        private TranslatorClientInterface $client,
        private TranslatorProfilerInterface $profiler,
    ) {
    }

    public function detect(string $query): DetectModel
    {
        $profile = $this->profiler->start('detect', $query);

        $detected = $this->client->getClient()->detectLanguage($query);

        $this->profiler->end($profile);

        return new DetectModel(
            $detected['languageCode'],
            $detected['confidence'] ?? null
        );
    }

    /**
     * @return string[]
     */
    public function languages(?string $targetLanguage): array
    {
        $profile = $this->profiler->start('languages', '', targetLanguage: $targetLanguage);

        $results = $this->client->getClient()->localizedLanguages([
            'target' => $targetLanguage,
        ]);

        $this->profiler->end($profile);

        return $results;
    }

    /**
     * @param string|string[] $query
     *
     * @return TranslateModel|TranslateModel[]
     */
    public function translate(string|array $query, string $targetLanguage = 'en', ?string $sourceLanguage = null, bool $isHtml = false): TranslateModel|array
    {
        if (!is_array($query)) {
            return $this->translateText($query, $targetLanguage, $sourceLanguage, $isHtml);
        }

        $text = implode(self::TEXT_DELIMITER, $query);
        $translated = $this->translateText($text, $targetLanguage, $sourceLanguage, $isHtml);
        $results = explode(self::TEXT_DELIMITER, $translated->text);

        $models = [];
        foreach ($results as $result) {
            /* @infection-ignore-all */
            $models[] = new TranslateModel(trim($result), $translated->sourceLanguage);
        }

        return $models;
    }

    private function translateText(string $query, string $targetLanguage, ?string $sourceLanguage, bool $isHtml): TranslateModel
    {
        $profile = $this->profiler->start('translate', $query, $sourceLanguage, $targetLanguage);

        $data = $this->client->getClient()->translate($query, [
            'target' => $targetLanguage,
            'source' => $sourceLanguage,
            'format' => $isHtml ? 'html' : 'text',
        ]);

        $this->profiler->end($profile);

        if (null === $data) {
            return new TranslateModel($query, '');
        }

        return new TranslateModel(
            $data['text'],
            $data['source'],
        );
    }
}
