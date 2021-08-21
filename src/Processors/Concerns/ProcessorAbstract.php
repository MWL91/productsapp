<?php

namespace App\Processors\Concerns;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ProcessorAbstract implements InputProcessorContract, OutputProcessorContract, FilenameContract
{
    protected array $data;
    protected string $filename;

    /**
     * ProcessorAbstract constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    abstract public function getFormat(): string;

    abstract public function fetch(): self;

    abstract public function getContent(): string;


    protected function getInputContent(string $file): string
    {
        $content = @file_get_contents($file);

        if (empty($content)) {
            throw new \RuntimeException("File is not readable");
        }

        return $content;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function store(): self
    {
        if (file_put_contents($this->filename, $this->getContent()) === false) {
            throw new \RuntimeException('File is not writable on ' . $this->filename);
        }

        return $this;
    }
}