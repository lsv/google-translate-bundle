<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Command;

use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'google-translate:translate',
    description: 'Translate a text',
)]
class TranslateCommand extends Command
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('to', InputArgument::REQUIRED, 'The language code to translate to');
        $this->addArgument('text', InputArgument::REQUIRED, 'The text to translate');
        $this->addOption('source', null, InputOption::VALUE_OPTIONAL, 'The language code to translate from');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $text = $input->getArgument('text');
        if (!is_string($text)) {
            throw new \InvalidArgumentException('Text must be a string');
        }

        $to = $input->getArgument('to');
        if (!is_string($to)) {
            throw new \InvalidArgumentException('To must be a string');
        }

        $source = $input->getOption('source');
        if (!is_string($source) && null !== $source) {
            throw new \InvalidArgumentException('Source must be a string');
        }

        $data = $this->translator->translate(
            $text,
            $to,
            $source
        );

        if (is_array($data)) {
            foreach ($data as $datum) {
                $output->writeln($datum->text);
            }

            return Command::SUCCESS;
        }

        $output->writeln($data->text);

        return Command::SUCCESS;
    }
}
