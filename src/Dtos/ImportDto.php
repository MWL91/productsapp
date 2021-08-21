<?php

namespace App\Dtos;

class ImportDto
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

    /**
     * @return string
     */
    public function getInputFormat(): string
    {
        return $this->inputFormat;
    }

    /**
     * @return string
     */
    public function getInputFile(): string
    {
        return $this->inputFile;
    }

    /**
     * @return string
     */
    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    /**
     * @return string
     */
    public function getOutputFile(): string
    {
        return $this->outputFile;
    }

}