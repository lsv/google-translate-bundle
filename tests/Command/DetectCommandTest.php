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

use Lsv\GoogleTranslationBundle\Command\DetectCommand;
use Lsv\GoogleTranslationBundle\Translate\Model\DetectModel;
use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DetectCommandTest extends TestCase
{
    private TranslatorInterface&MockObject $translator;
    private InputInterface&MockObject $input;
    private OutputInterface&MockObject $output;
    private DetectCommand $command;

    protected function setUp(): void
    {
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);
        $this->command = new DetectCommand($this->translator);
    }

    public function testDefinition(): void
    {
        $definition = $this->command->getDefinition();
        self::assertTrue($definition->hasArgument('text'));
    }

    public function testDetectCommand(): void
    {
        $this->translator
            ->expects($this->once())
            ->method('detect')
            ->with('Hello')
            ->willReturn(new DetectModel('en', 1));

        $this->input
            ->expects($this->once())
            ->method('getArgument')
            ->with('text')
            ->willReturn('Hello');

        $this->output
            ->expects($this->exactly(2))
            ->method('writeln')
            ->with($this->callback(
                static fn (string $message): bool => in_array($message, ['Language code: en', 'Confidence: 1'], true))
            );

        $this->command->run($this->input, $this->output);
    }

    public function testDetectCommandNotTextInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Text must be a string');

        $this->translator
            ->expects($this->never())
            ->method('detect');

        $this->input = $this->createMock(InputInterface::class);
        $this->input
            ->expects($this->once())
            ->method('getArgument')
            ->with('text')
            ->willReturn(['Foo']);

        $this->command->run($this->input, $this->output);
    }
}
