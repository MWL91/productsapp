<?php

namespace App\Command;

use App\Exceptions\InvalidFormatException;
use App\Services\Contracts\ImportServiceContract;
use Mockery\Exception\RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import',
    description: 'Add a short description for your command',
)]
class ImportCommand extends Command
{
    private ImportServiceContract $importService;

    /**
     * ImportCommand constructor.
     * @param ImportServiceContract $importService
     */
    public function __construct(ImportServiceContract $importService)
    {
        parent::__construct();

        $this->importService = $importService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'File path or url to import')
            ->addOption('input', null, InputOption::VALUE_OPTIONAL, 'Input format', 'xml')
            ->addOption('output', null, InputOption::VALUE_OPTIONAL, 'Output format', 'csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $inputProcessor = $this->importService->getInputProcessor($input->getOption('input'));
            $outputProcessor = $this->importService->getOutputProcessor($input->getOption('output'));
        } catch (\RuntimeException $exception) {
            $io->error($exception->getMessage());
            return Command::INVALID;
        }

        $this->importService->import($input->getArgument('file'), $inputProcessor, $outputProcessor);

        $io->success('Success.');

        return Command::SUCCESS;
    }
}
