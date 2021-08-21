<?php

namespace App\Services\Contracts;

use App\Inputs\Concerns\InputContract;
use App\Outputs\Concerns\OutputContract;

interface ImportServiceContract
{
    public function getInputProcessor(string $format): InputContract;

    public function getOutputProcessor(string $format): OutputContract;

    public function import(string $file, InputContract $inputFormat, OutputContract $outputFormat): OutputContract;
}