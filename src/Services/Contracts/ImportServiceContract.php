<?php

namespace App\Services\Contracts;

use App\Dtos\ImportDto;
use App\Processors\Concerns\InputProcessorContract;

interface ImportServiceContract
{
    public function getProcessor(string $format, string $filename): InputProcessorContract;

    public function processImport(InputProcessorContract $input, InputProcessorContract $output): InputProcessorContract;

    public function import(ImportDto $importDto): InputProcessorContract;
}