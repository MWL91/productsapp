<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

interface OutputProcessorContract
{
    public function applyInput(InputProcessorContract $input): self;

    public function encode(): string;

    public function store(): void;
}
