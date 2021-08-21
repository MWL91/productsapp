<?php

declare(strict_types=1);

namespace App\Processors;

use App\Processors\Concerns\SerializerProcessor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class XmlProcessor extends SerializerProcessor
{
    public const FORMAT = 'xml';

    protected function getSerializer(): SerializerInterface
    {
        return new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
    }

    public function getFormat(): string
    {
        return self::FORMAT;
    }
}
