<?php

namespace App\Services;

use App\Inputs\Concerns\InputContract;
use App\Outputs\Concerns\OutputContract;
use App\Services\Contracts\ImportServiceContract;

class ImportService implements ImportServiceContract
{

    public function getInputProcessor(string $format): InputContract
    {
        $className = 'App\\Inputs\\' . ucfirst($format) . 'Input';

        if (!class_exists($className)) {
            throw new \RuntimeException("Input format " . $format . " not exists.");
        }

        return new $className();
    }

    public function getOutputProcessor(string $format): OutputContract
    {
        $className = 'App\\Outputs\\' . ucfirst($format) . 'Output';

        if (!class_exists($className)) {
            throw new \RuntimeException("Output format " . $format . " not exists.");
        }

        return new $className();
    }

    public function import(string $file, InputContract $inputFormat, OutputContract $outputFormat): OutputContract
    {
        // TODO: get file
        // TODO: normalize in $inputFormat
        // TODO: set $outputFormat data
        // TODO: return OutputContract with data set -> to file
    }
}