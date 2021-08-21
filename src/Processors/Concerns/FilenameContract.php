<?php

namespace App\Processors\Concerns;

interface FilenameContract
{
    public function setFilename(string $filename): void;

    public function getFilename(): string;
}