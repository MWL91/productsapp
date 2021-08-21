<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

interface FilenameContract
{
    public function getFilename(): string;
}
