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

namespace Lsv\GoogleTranslationBundle\Tests\Translate\Profiler;

use Lsv\GoogleTranslationBundle\Translate\Profiler\GoogleTranslatorProfiler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

class TranslatorProfilerTest extends TestCase
{
    public function testCanStartProfiler(): void
    {
        $profiler = new GoogleTranslatorProfiler(new Stopwatch());
        $event = $profiler->start('test', 'query', 'en', 'sv');
        usleep(250);
        self::assertNotNull($event);
        $this->assertTrue($event->isStarted());
        $profiler->end($event);
        /* @noinspection PhpConditionAlreadyCheckedInspection */
        $this->assertFalse($event->isStarted());

        self::assertCount(1, $profiler->getProfiles());
        self::assertNotNull($profiler->getProfiles()[0]->duration, 'duration');
        self::assertNotNull($profiler->getProfiles()[0]->memoryEnd, 'end memory');
        self::assertNotNull($profiler->getProfiles()[0]->memoryPeak, 'peak memory');
    }

    public function testEventNotSet(): void
    {
        $this->expectNotToPerformAssertions();
        $profiler = new GoogleTranslatorProfiler(new Stopwatch());
        $profiler->end();
    }

    public function testWillNotProfileIfStopWatchNotFound(): void
    {
        $profiler = new GoogleTranslatorProfiler();
        $event = $profiler->start('test', 'query', 'en', 'sv');
        $this->assertNull($event);
        $profiler->end($event);
        self::assertCount(0, $profiler->getProfiles());
    }
}
