<?php

namespace App\Inputs\Concerns;

interface InputContract
{
    public function fetch(string $file): self;

    public function getData(): array;
}