<?php

declare(strict_types=1);

namespace App\Command;

use App\Dtos\ImportDto;
use App\Services\Contracts\ImportServiceContract;
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
final class ImportCommand extends Command
{
    private ImportServiceContract $importService;

    /**
     * ImportCommand constructor.
     */
    public function __construct(ImportServiceContract $importService)
    {
        parent::__construct();

        $this->importService = $importService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('inputFile', InputArgument::REQUIRED, 'File path or url to import')
            ->addArgument('outputFile', InputArgument::REQUIRED, 'File path or url to export')
            ->addOption('inputFormat', null, InputOption::VALUE_OPTIONAL, 'Input format', 'xml')
            ->addOption('outputFormat', null, InputOption::VALUE_OPTIONAL, 'Output format', 'csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $output = $this->importService->import(
                new ImportDto(
                    $input->getOption('inputFormat'),
                    $input->getArgument('inputFile'),
                    $input->getOption('outputFormat'),
                    $input->getArgument('outputFile')
                )
            );
        } catch (\RuntimeException $exception) {
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('File successfully stored at `' . $output->getFilename() . '`.');

        return Command::SUCCESS;
    }
}
