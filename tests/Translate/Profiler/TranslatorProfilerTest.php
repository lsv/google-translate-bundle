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

namespace Lsv\GoogleTranslationBundle\Tests\Translate\Profiler;

use Lsv\GoogleTranslationBundle\Translate\Profiler\GoogleTranslatorProfiler;
use PHPUnit\Framework\TestCase;

class TranslatorProfilerTest extends TestCase
{
    public function testCanStartProfiler(): void
    {
        $profiler = new GoogleTranslatorProfiler();
        $event = $profiler->start('test', 'query', 'en', 'sv');
        usleep(250);
        self::assertNotNull($event);
        $profiler->end($event);

        self::assertCount(1, $profiler->getProfiles());
        self::assertNotNull($profiler->getProfiles()[0]->startDuration, 'start duration');
        self::assertNotNull($profiler->getProfiles()[0]->endDuration, 'end duration');
        self::assertNotNull($profiler->getProfiles()[0]->memoryEnd, 'end memory');
        self::assertNotNull($profiler->getProfiles()[0]->memoryPeak, 'peak memory');
    }
}
