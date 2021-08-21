<?php

declare(strict_types=1);

namespace App\Dtos;

final class ImportDto
{
    private string $inputFormat;
    private string $inputFile;
    private string $outputFormat;
    private string $outputFile;

    /**
     * ImportDto constructor.
     */
    public function __construct(string $inputFormat, string $inputFile, string $outputFormat, string $outputFile)
    {
        $this->inputFormat = $inputFormat;
        $this->inputFile = $inputFile;
        $this->outputFormat = $outputFormat;
        $this->outputFile = $outputFile;
    }

    public function getInputFormat(): string
    {
        return $this->inputFormat;
    }

    public function getInputFile(): string
    {
        return $this->inputFile;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function getOutputFile(): string
    {
        return $this->outputFile;
    }
}
