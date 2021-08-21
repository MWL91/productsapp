<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

abstract class Processor implements InputProcessorContract, OutputProcessorContract, FilenameContract
{
    protected array $data;
    protected string $filename;

    public function __construct(string $filename, array $data = [])
    {
        $this->filename = $filename;
        $this->data = $data;
    }

    abstract public function getFormat(): string;

    abstract public function fetch(): self;

    abstract public function getContent(): string;

    public function getData(): array
    {
        return $this->data;
    }

    public function applyInput(InputProcessorContract $input): self
    {
        $input->fetch();
        $this->data = $input->getData();

        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function store(): self
    {
        if (@file_put_contents($this->filename, $this->getContent()) === false) {
            throw new \RuntimeException('File is not writable on '.$this->filename);
        }

        return $this;
    }

    protected function getInputContent(string $file): string
    {
        $content = @file_get_contents($file);

        if (empty($content)) {
            throw new \RuntimeException('File is not readable');
        }

        return $content;
    }
}
