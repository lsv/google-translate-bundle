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

namespace Lsv\GoogleTranslationBundle\Tests\Command;

use Lsv\GoogleTranslationBundle\Command\TranslateCommand;
use Lsv\GoogleTranslationBundle\Translate\Model\TranslateModel;
use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateCommandTest extends TestCase
{
    private OutputInterface&MockObject $output;
    private InputInterface&MockObject $input;
    private TranslatorInterface&MockObject $translator;
    private TranslateCommand $command;

    protected function setUp(): void
    {
        $this->output = $this->createMock(OutputInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->command = new TranslateCommand($this->translator);
    }

    public function testDefinition(): void
    {
        $definition = $this->command->getDefinition();
        self::assertTrue($definition->hasArgument('to'));
        self::assertTrue($definition->hasArgument('text'));
        self::assertTrue($definition->hasOption('source'));
    }

    public function testTranslate(): void
    {
        $this->translator
            ->expects($this->once())
            ->method('translate')
            ->with('Hello', 'da')
            ->willReturn(new TranslateModel('Translated', 'en'));

        $this->input
            ->expects($this->exactly(2))
            ->method('getArgument')
            ->willReturnOnConsecutiveCalls(['text', 'to'])
            ->willReturnOnConsecutiveCalls('Hello', 'da');

        $this->output
            ->expects($this->once())
            ->method('writeln')
            ->with('Translated');

        $this->command->run($this->input, $this->output);
    }

    public function testTranslateArray(): void
    {
        $this->translator
            ->expects($this->once())
            ->method('translate')
            ->with('Hello', 'da')
            ->willReturn(
                [
                    new TranslateModel('Line 1', 'en'),
                    new TranslateModel('Line 2', 'en'),
                ],
            );

        $this->input
            ->expects($this->exactly(2))
            ->method('getArgument')
            ->willReturnOnConsecutiveCalls('Hello', 'da');

        $this->input
            ->expects($this->once())
            ->method('getOption')
            ->with('source')
            ->willReturn(null);

        $this->output
            ->expects($this->exactly(2))
            ->method('writeln')
            ->with($this->callback(
                static fn (string $message): bool => in_array($message, ['Line 1', 'Line 2'], true))
            );

        $this->command->run($this->input, $this->output);
    }

    public static function provideIsText(): \Generator
    {
        yield 'text is null' => [null, 'da', 'en'];
        yield 'text is array' => [[], 'da', 'en'];
        yield 'target is null' => ['Hello', null, 'en'];
        yield 'target is array' => ['Hello', [], 'en'];
        yield 'source is not text' => ['Hello', 'da', []];
    }

    #[DataProvider('provideIsText')]
    public function testIsText(mixed $text, mixed $target, mixed $source): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->translator
            ->expects($this->never())
            ->method('translate');

        $this->input
            ->method('getArgument')
            ->willReturnOnConsecutiveCalls(['text', 'to'])
            ->willReturnOnConsecutiveCalls($text, $target);

        $this->input
            ->method('getOption')
            ->with('source')
            ->willReturn($source);

        $this->command->run($this->input, $this->output);
    }
}
