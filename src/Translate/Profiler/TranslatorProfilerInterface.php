<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Profiler;

use Symfony\Component\Stopwatch\StopwatchEvent;

interface TranslatorProfilerInterface
{
    public function start(
        string $type,
        string $query,
        ?string $sourceLanguage = null,
        ?string $targetLanguage = null,
    ): ?StopwatchEvent;

    public function end(?StopwatchEvent $event = null): void;

    /**
     * @return TranslationProfileModel[]
     */
    public function getProfiles(): array;
}
