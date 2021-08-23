<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

interface InputProcessorContract
{
    public function getFormat(): string;

    public function decode(): self;

    public function getData(): array;

    public function applyRawContent(string $rawContent): self;

    public function fetchRawContent(): string;
}
