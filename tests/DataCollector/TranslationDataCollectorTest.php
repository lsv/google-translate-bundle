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

class TranslationDataCollectorTest extends TestCase
{
    private GoogleTranslatorProfiler $profiler;
    private TranslationDataCollector $collector;

    protected function setUp(): void
    {
        $this->profiler = new GoogleTranslatorProfiler();
        $this->collector = new TranslationDataCollector($this->profiler);
    }

    public function testGetCollectorName(): void
    {
        self::assertSame('lsv_google_translate', $this->collector->getName());
    }

    public function testWillInsertData(): void
    {
        $event = $this->profiler->start('test', 'query', 'en', 'sv');
        $this->profiler->end($event);

        $event = $this->profiler->start('test2', 'query', 'en', 'sv');
        $this->profiler->end($event);

        $this->collector->collect(new Request(), new Response());
        self::assertCount(2, $this->collector->getData());

        $key = array_key_first((array) $this->collector->getData());
        $data = $this->collector->getData()[$key][0];

        self::assertNotNull($data['query']);
        self::assertNotNull($data['sourceLanguage']);
        self::assertNotNull($data['targetLanguage']);
        self::assertNotNull($data['duration']);
        self::assertGreaterThan(0, $data['duration']);
        self::assertLessThan(500, $data['duration']);
        self::assertNotNull($data['memoryEnd']);
        self::assertNotNull($data['memoryPeak']);
    }
}
