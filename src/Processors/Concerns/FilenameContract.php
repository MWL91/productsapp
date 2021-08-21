<?php

namespace App\Processors\Concerns;

interface FilenameContract
{
    public function getFilename(): string;
}