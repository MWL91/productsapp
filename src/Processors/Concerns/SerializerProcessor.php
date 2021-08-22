<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

use Symfony\Component\Serializer\SerializerInterface;

abstract class SerializerProcessor extends Processor
{
    public function decode(): self
    {
        $this->data = $this->getSerializer()->decode($this->getRawContent(), $this->getFormat());
        return $this;
    }

    public function encode(): string
    {
        return $this->getSerializer()->encode($this->data, $this->getFormat());
    }

    abstract protected function getSerializer(): SerializerInterface;
}
