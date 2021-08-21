<?php

declare(strict_types=1);

namespace App\Processors\Concerns;

use Symfony\Component\Serializer\SerializerInterface;

abstract class SerializerProcessor extends Processor
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

    abstract protected function getSerializer(): SerializerInterface;
}
