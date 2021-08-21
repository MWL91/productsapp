<?php

declare(strict_types=1);

namespace App\Processors;

use App\Processors\Concerns\SerializerProcessor;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class CsvProcessor extends SerializerProcessor
{
    public const FORMAT = 'csv';

    public function getFormat(): string
    {
        return self::FORMAT;
    }

    protected function getSerializer(): SerializerInterface
    {
        return new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
    }
}
