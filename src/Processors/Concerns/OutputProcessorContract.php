<?php

namespace App\Processors\Concerns;

interface OutputProcessorContract
{
    public function getContent(): string;

    public function store(): self;

    public function applyInput(InputProcessorContract $input): self;
}