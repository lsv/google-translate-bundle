<?php

declare(strict_types=1);

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
            $this->data[$profile->type][] = $profile;
        }
    }

    public function getName(): string
    {
        return 'lsv.google_translate.data_collector.translate';
    }

    /**
     * @return array<mixed>|Data
     */
    public function getData(): array|Data
    {
        return $this->data;
    }
}
