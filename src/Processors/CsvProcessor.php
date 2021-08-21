<?php

namespace App\Processors;

use App\Processors\Concerns\SerializerProcessorAbstract;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class CsvProcessor extends SerializerProcessorAbstract
{
    public const FORMAT = 'csv';

    protected function getSerializer(): SerializerInterface
    {
        return new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
    }

    public function getFormat(): string
    {
        return self::FORMAT;
    }
}