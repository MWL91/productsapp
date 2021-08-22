<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

use Symfony\Component\Serializer\SerializerInterface;

abstract class SerializerProcessor extends Processor
{
    public function decode(): self
    {
        $data = $this->getSerializer()->decode($this->getRawContent(), $this->getFormat());
        $this->data = end($data);
        return $this;
    }

    public function encode(): string
    {
        return $this->getSerializer()->encode($this->data, $this->getFormat());
    }

    abstract protected function getSerializer(): SerializerInterface;
}
