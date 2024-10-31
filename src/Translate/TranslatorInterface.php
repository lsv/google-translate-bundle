<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate;

use Lsv\GoogleTranslationBundle\Translate\Model\DetectModel;
use Lsv\GoogleTranslationBundle\Translate\Model\TranslateModel;

interface TranslatorInterface
{
    public function detect(string $query): DetectModel;

    /**
     * @return string[]
     */
    public function languages(?string $targetLanguage): array;

    /**
     * @param string|string[] $query
     *
     * @return TranslateModel|TranslateModel[]
     */
    public function translate(
        string|array $query,
        string $targetLanguage = 'en',
        ?string $sourceLanguage = null,
        bool $isHtml = false,
    ): TranslateModel|array;
}
