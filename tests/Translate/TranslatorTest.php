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

namespace Lsv\GoogleTranslationBundle\Tests\Translate;

use Google\Cloud\Translate\V2\TranslateClient;
use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;
use Lsv\GoogleTranslationBundle\Translate\GoogleTranslator;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\StopwatchEvent;

class TranslatorTest extends TestCase
{
    private TranslatorProfilerInterface&MockObject $profiler;
    private TranslateClient&MockObject $client;
    private GoogleTranslator $translator;

    protected function setUp(): void
    {
        $this->client = $this->createMock(TranslateClient::class);
        $this->profiler = $this->createMock(TranslatorProfilerInterface::class);

        $client = $this->createMock(TranslatorClientInterface::class);
        $client
            ->method('getClient')
            ->willReturn($this->client);

        $this->translator = new GoogleTranslator(
            $client,
            $this->profiler,
        );
    }

    public function testCanDetectLanguage(): void
    {
        $this->client->expects($this->once())
            ->method('detectLanguage')
            ->with('Hello')
            ->willReturn(['languageCode' => 'en']);

        $event = $this->createMock(StopwatchEvent::class);
        $this->profiler
            ->expects($this->once())
            ->method('start')
            ->with('detect', 'Hello', null, null)
            ->willReturn($event);

        $this->profiler
            ->expects($this->once())
            ->method('end')
            ->with($event);

        $detected = $this->translator->detect('Hello');
        self::assertNull($detected->confidence);
        self::assertSame('en', $detected->code);
    }

    public function testCanGetLanguages(): void
    {
        $this->client->expects($this->once())
            ->method('localizedLanguages')
            ->with(['target' => 'en'])
            ->willReturn(['en', 'da', 'sv']);

        $event = $this->createMock(StopwatchEvent::class);
        $this->profiler
            ->expects($this->once())
            ->method('start')
            ->with('languages', '', null, 'en')
            ->willReturn($event);

        $this->profiler
            ->expects($this->once())
            ->method('end')
            ->with($event);

        $languages = $this->translator->languages('en');
        self::assertCount(3, $languages);
        self::assertSame(['en', 'da', 'sv'], $languages);
    }

    public function testTranslateString(): void
    {
        $this->client->expects($this->once())
            ->method('translate')
            ->with('Hello World', ['target' => 'da', 'source' => 'en', 'format' => 'text'])
            ->willReturn([
                'source' => 'en',
                'input' => 'Hello World',
                'text' => 'Hej Verden',
            ]);

        $event = $this->createMock(StopwatchEvent::class);
        $this->profiler
            ->expects($this->once())
            ->method('start')
            ->with('translate', 'Hello World', 'en', 'da')
            ->willReturn($event);

        $this->profiler
            ->expects($this->once())
            ->method('end')
            ->with($event);

        $languages = $this->translator->translate('Hello World', 'da', 'en');
        self::assertIsNotArray($languages);
        self::assertSame('Hej Verden', $languages->text);
    }

    public function testTranslateArray(): void
    {
        $this->client->expects($this->once())
            ->method('translate')
            ->with('Hello World#.#.# World Hello', ['target' => 'da', 'source' => 'en', 'format' => 'text'])
            ->willReturn([
                'source' => 'en',
                'input' => 'Hello World#.#.#World Hello',
                'text' => 'Hej Verden#.#.#Verden Hej',
            ]);

        $event = $this->createMock(StopwatchEvent::class);
        $this->profiler
            ->expects($this->once())
            ->method('start')
            ->with('translate', 'Hello World#.#.# World Hello', 'en', 'da')
            ->willReturn($event);

        $this->profiler
            ->expects($this->once())
            ->method('end')
            ->with($event);

        $languages = $this->translator->translate(['Hello World', ' World Hello'], 'da', 'en');
        self::assertIsArray($languages);
        self::assertCount(2, $languages);
        self::assertSame('Hej Verden', $languages[0]->text);
        self::assertSame('Verden Hej', $languages[1]->text);
    }

    public function testCanNotTranslate(): void
    {
        $this->client->expects($this->once())
            ->method('translate')
            ->with('Hello World', ['target' => 'da', 'source' => 'en', 'format' => 'text'])
            ->willReturn(null);

        $event = $this->createMock(StopwatchEvent::class);
        $this->profiler
            ->expects($this->once())
            ->method('start')
            ->with('translate', 'Hello World', 'en', 'da')
            ->willReturn($event);

        $this->profiler
            ->expects($this->once())
            ->method('end')
            ->with($event);

        $languages = $this->translator->translate('Hello World', 'da', 'en');
        self::assertIsNotArray($languages);
        self::assertSame('Hello World', $languages->text);
        self::assertSame('', $languages->sourceLanguage);
    }
}
