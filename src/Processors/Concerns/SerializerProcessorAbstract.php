<?php

namespace App\Processors\Concerns;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class SerializerProcessorAbstract extends ProcessorAbstract
{
    public function fetch(): self
    {
        $this->data = $this->getSerializer()->decode($this->getInputContent($this->filename), $this->getFormat())['item'];

        return $this;
    }

    public function getContent(): string
    {
        return $this->getSerializer()->encode($this->data, $this->getFormat());
    }
}