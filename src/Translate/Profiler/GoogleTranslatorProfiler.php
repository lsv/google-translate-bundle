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

use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

final class GoogleTranslatorProfiler implements TranslatorProfilerInterface
{
    /**
     * @var TranslationProfileModel[]
     */
    private array $profiles = [];

    /**
     * @var TranslationProfileModel[]
     */
    private array $startedProfiles = [];

    public function __construct(
        private readonly ?Stopwatch $stopwatch = null,
    ) {
    }

    public function start(string $type, string $query, ?string $sourceLanguage = null, ?string $targetLanguage = null): ?StopwatchEvent
    {
        if (!$this->stopwatch) {
            return null;
        }

        /** @infection-ignore-all */
        $name = md5($type.$query.$sourceLanguage.$targetLanguage);

        $this->startedProfiles[$name] = new TranslationProfileModel(
            $type,
            $query,
            $sourceLanguage,
            $targetLanguage,
            memory_get_usage(),
        );

        return $this->stopwatch->start($name);
    }

    public function end(?StopwatchEvent $event = null): void
    {
        if (!$this->stopwatch || !$event) {
            return;
        }

        $event->stop();

        // @codeCoverageIgnoreStart
        if (!isset($this->startedProfiles[$event->getName()])) {
            return;
        }
        // @codeCoverageIgnoreEnd

        $this->startedProfiles[$event->getName()]->setMemoryEnd($event->getMemory());
        $this->startedProfiles[$event->getName()]->setDuration($event->getDuration());
        $this->startedProfiles[$event->getName()]->setMemoryPeak(memory_get_peak_usage(true));
        $this->profiles[] = $this->startedProfiles[$event->getName()];
        unset($this->startedProfiles[$event->getName()]);
    }

    public function getProfiles(): array
    {
        return $this->profiles;
    }
}
