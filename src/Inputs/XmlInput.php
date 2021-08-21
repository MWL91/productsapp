<?php

namespace App\Inputs;

use App\Inputs\Concerns\AbstractInput;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

final class XmlInput extends AbstractInput
{
    public function fetch(string $file): self
    {
        $this->data = $this->getSerializer(new XmlEncoder())
            ->decode($this->getContent($file), 'xml')['item'];

        return $this;
    }
}