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

namespace Lsv\GoogleTranslationBundle\Tests\DataCollector;

use Lsv\GoogleTranslationBundle\DataCollector\TranslationDataCollector;
use Lsv\GoogleTranslationBundle\Translate\Profiler\GoogleTranslatorProfiler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Stopwatch\Stopwatch;

class TranslationDataCollectorTest extends TestCase
{
    private GoogleTranslatorProfiler $profiler;

    protected function setUp(): void
    {
        $this->profiler = new GoogleTranslatorProfiler(new Stopwatch());
    }

    public function testGetCollectorName(): void
    {
        $collector = new TranslationDataCollector($this->profiler);
        self::assertSame('lsv.google_translate.data_collector.translate', $collector->getName());
    }

    public function testWillInsertData(): void
    {
        $event = $this->profiler->start('test', 'query', 'en', 'sv');
        $this->profiler->end($event);

        $event = $this->profiler->start('test2', 'query', 'en', 'sv');
        $this->profiler->end($event);

        $collector = new TranslationDataCollector($this->profiler);
        $collector->collect(new Request(), new Response());
        self::assertCount(2, $collector->getData());
    }
}
