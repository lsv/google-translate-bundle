<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

namespace Lsv\GoogleTranslationBundle\Translate\Profiler;

class TranslationProfileModel
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $query,
        public readonly ?string $sourceLanguage,
        public readonly ?string $targetLanguage,
        public int $memoryStart,
        public int|float $startDuration,
        public int|float|null $endDuration = null,
        public ?int $memoryEnd = null,
        public ?int $memoryPeak = null,
    ) {
    }

    public function setEndDuration(int|float $duration): void
    {
        $this->endDuration = $duration;
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
