<?php

namespace App\Processors\Concerns;

interface InputProcessorContract
{
    public function getFormat(): string;

    public function fetch(): self;

    public function getData(): array;

    public function setData(array $data): self;
}