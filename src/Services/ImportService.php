<?php

namespace App\Services;

use App\Inputs\Concerns\InputContract;
use App\Outputs\Concerns\OutputContract;
use App\Services\Contracts\ImportServiceContract;

class ImportService implements ImportServiceContract
{

    public function getInputProcessor(string $format)
    {
        // TODO: Implement getInputProcessor() method.
    }

    public function getOutputProcessor(string $format)
    {
        // TODO: Implement getOutputProcessor() method.
    }

    public function import(string $file, InputContract $inputFormat, OutputContract $outputFormat)
    {
        // TODO: Implement import() method.
    }
}