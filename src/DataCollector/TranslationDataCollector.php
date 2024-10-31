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

namespace Lsv\GoogleTranslationBundle\DataCollector;

use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\VarDumper\Cloner\Data;

class TranslationDataCollector extends DataCollector
{
    public function __construct(
        private readonly TranslatorProfilerInterface $profiler,
    ) {
    }

    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
        foreach ($this->profiler->getProfiles() as $profile) {
            $this->data[$profile->type][] = [
                'query' => $profile->query,
                'sourceLanguage' => $profile->sourceLanguage,
                'targetLanguage' => $profile->targetLanguage,
                'duration' => $profile->endDuration - $profile->startDuration,
                'memoryEnd' => $profile->memoryEnd,
                'memoryPeak' => $profile->memoryPeak,
            ];
        }
    }

    /**
     * @return array<mixed>|Data
     */
    public function getData(): array|Data
    {
        return $this->data;
    }

    public function getName(): string
    {
        return 'lsv_google_translate';
    }
}
