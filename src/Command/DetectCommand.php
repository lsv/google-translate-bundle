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

namespace Lsv\GoogleTranslationBundle\Command;

use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'google-translate:detect',
    description: 'Detect language code',
)]
class DetectCommand extends Command
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('text', InputArgument::REQUIRED, 'The text to translate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $text = $input->getArgument('text');
        if (!is_string($text)) {
            throw new \InvalidArgumentException('Text must be a string');
        }

        $data = $this->translator->detect(
            $text,
        );

        $output->writeln('Language code: '.$data->code);

        if ($data->confidence) {
            $output->writeln('Confidence: '.$data->confidence);
        }

        return Command::SUCCESS;
    }
}
