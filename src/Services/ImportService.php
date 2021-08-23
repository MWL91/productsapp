<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\ImportDto;
use App\Processors\Concerns\InputProcessorContract;
use App\Processors\Concerns\IOProcessorContract;
use App\Processors\Concerns\OutputProcessorContract;
use App\Services\Contracts\ImportServiceContract;
use RuntimeException;

final class ImportService implements ImportServiceContract
{
    public function getProcessor(string $format, string $filename): IOProcessorContract
    {
        $className = 'App\\Processors\\' . ucfirst($format) . 'Processor';

        if (! class_exists($className)) {
            throw new RuntimeException('Input format ' . $format . ' not exists.');
        }

        return new $className($filename);
    }

    public function processImport(
        InputProcessorContract $input,
        OutputProcessorContract $output
    ): OutputProcessorContract {
        $input->applyRawContent($input->fetchRawContent());
        $output->applyInput($input);
        $output->store();

        return $output;
    }

    public function import(ImportDto $importDto): OutputProcessorContract
    {
        if (str_starts_with($importDto->getInputFile(), 'phar://')) {
            throw new RuntimeException('You can not use phar protocol as input.');
        }

        $inputProcessor = $this->getProcessor($importDto->getInputFormat(), $importDto->getInputFile());
        $outputProcessor = $this->getProcessor($importDto->getOutputFormat(), $importDto->getOutputFile());

        return $this->processImport($inputProcessor, $outputProcessor);
    }
}
