<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Dtos\ImportDto;
use App\Processors\Concerns\InputProcessorContract;
use App\Processors\Concerns\OutputProcessorContract;

interface ImportServiceContract
{
    public function getProcessor(string $format, string $filename): InputProcessorContract;

    public function processImport(
        InputProcessorContract $input,
        OutputProcessorContract $output
    ): OutputProcessorContract;

    public function import(ImportDto $importDto): InputProcessorContract;
}
