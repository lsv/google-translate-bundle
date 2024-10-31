<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Profiler;

final class TranslationProfileModel
{
    public function __construct(
        public readonly string $type,
        public readonly string $query,
        public readonly ?string $sourceLanguage,
        public readonly ?string $targetLanguage,
        public int $memoryStart,
        public int|float|null $duration = null,
        public ?int $memoryEnd = null,
        public ?int $memoryPeak = null,
    ) {
    }

    public function setDuration(int|float $duration): void
    {
        $this->duration = $duration;
    }

    public function setMemoryEnd(int $memoryEnd): void
    {
        $this->memoryEnd = $memoryEnd;
    }

    public function setMemoryPeak(int $memoryPeak): void
    {
        $this->memoryPeak = $memoryPeak;
    }
}
