<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

namespace Lsv\GoogleTranslationBundle\Translate\Profiler;

final class GoogleTranslatorProfiler implements TranslatorProfilerInterface
{
    /**
     * @var TranslationProfileModel[]
     */
    private array $profiles = [];

    public function start(string $type, string $query, ?string $sourceLanguage = null, ?string $targetLanguage = null): TranslationProfileModel
    {
        /** @infection-ignore-all */
        $name = md5($type.$query.$sourceLanguage.$targetLanguage);

        return new TranslationProfileModel(
            $name,
            $type,
            $query,
            $sourceLanguage,
            $targetLanguage,
            memory_get_usage(),
            microtime(true),
        );
    }

    public function end(TranslationProfileModel $event): void
    {
        $event->setEndDuration(microtime(true));
        $event->setMemoryEnd(memory_get_usage());
        $event->setMemoryPeak(memory_get_peak_usage());

        $this->profiles[] = $event;
    }

    public function getProfiles(): array
    {
        return $this->profiles;
    }
}
