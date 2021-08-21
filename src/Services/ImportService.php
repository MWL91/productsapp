<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\ImportDto;
use App\Processors\Concerns\InputProcessorContract;
use App\Services\Contracts\ImportServiceContract;

final class ImportService implements ImportServiceContract
{
    public function getProcessor(string $format, string $filename): InputProcessorContract
    {
        $className = 'App\\Processors\\' . ucfirst($format) . 'Processor';

        if (!class_exists($className)) {
            throw new \RuntimeException('Input format ' . $format . ' not exists.');
        }

        return new $className($filename);
    }

    public function processImport(
        InputProcessorContract $input,
        InputProcessorContract $output
    ): InputProcessorContract
    {
        return $output->applyInput($input)->store();
    }

    public function import(ImportDto $importDto): InputProcessorContract
    {
        if (substr($importDto->getInputFile(), 0, 7) === 'phar://') {
            throw new \RuntimeException('You can not use phar protocol as input.');
        }

        $inputProcessor = $this->getProcessor($importDto->getInputFormat(), $importDto->getInputFile());
        $outputProcessor = $this->getProcessor($importDto->getOutputFormat(), $importDto->getOutputFile());

        return $this->processImport($inputProcessor, $outputProcessor);
    }
}
