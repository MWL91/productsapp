<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

abstract class Processor implements InputProcessorContract, OutputProcessorContract, FilenameContract
{
    protected array $data;
    protected string $filename;
    protected ?string $rawContent;

    public function __construct(string $filename, ?string $rawContent = null, array $data = [])
    {
        $this->filename = $filename;
        $this->rawContent = $rawContent;
        $this->data = $data;
    }

    abstract public function getFormat(): string;

    abstract public function decode(): self;

    abstract public function encode(): string;

    public function getData(): array
    {
        return $this->data;
    }

    public function applyInput(InputProcessorContract $input): self
    {
        $input->decode();
        $this->data = $input->getData();

        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getRawContent(): ?string
    {
        return $this->rawContent;
    }

    public function applyRawContent(string $rawContent): self
    {
        $this->rawContent = $rawContent;
        return $this;
    }

    public function store(): void
    {
        if (@file_put_contents($this->getFilename(), $this->encode()) === false) {
            throw new \RuntimeException('File is not writable on ' . $this->getFilename());
        }
    }
}
