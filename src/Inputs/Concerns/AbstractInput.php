<?php

namespace App\Inputs\Concerns;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractInput implements InputContract
{
    protected array $data;

    protected function getContent(string $file): string
    {
        $content = @file_get_contents($file);

        if (empty($content)) {
            throw new \RuntimeException("File is not readable");
        }

        return $content;
    }

    protected function getSerializer(EncoderInterface $encoder): SerializerInterface
    {
        return new Serializer([new ObjectNormalizer()], [$encoder]);
    }

    public function getData(): array
    {
        return $this->data;
    }
}