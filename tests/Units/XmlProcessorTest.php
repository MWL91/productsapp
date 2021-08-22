<?php

declare(strict_types=1);

namespace App\Tests\Units;

use App\Processors\Concerns\Processor;
use App\Processors\CsvProcessor;
use App\Processors\XmlProcessor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlProcessorTest extends KernelTestCase
{
    public function test_use_serializer(): void
    {
        self::bootKernel();

        $encoders = [new XmlEncoder(), new CsvEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $payload = file_get_contents(__DIR__ . '/../resources/coffee_feed.xml');

        $data = $serializer->decode($payload, 'xml');
        $csvData = $serializer->encode($data, 'csv');
        $dataFromCsv = $serializer->decode($csvData, 'csv');

        $this->assertCount(3449, $data['item']);
        $this->assertIsString($csvData);
        $this->assertCount(3449, $dataFromCsv[0]['item']);
    }

    public function test_fetch_data_from_xml_input(): void
    {
        $inputFile = __DIR__ . '/../resources/coffee_feed.xml';
        $input = new XmlProcessor($inputFile, file_get_contents($inputFile));
        $input->decode();

        $this->assertCount(3449, $input->getData());
        $this->assertIsString($input->encode());
    }

    /**
     * @dataProvider invalidFilesDataProvider
     */
    public function test_fetch_data_from_xml_input_when_invalid_file(string $fileName, string $fileContent): void
    {
        $this->expectException(\RuntimeException::class);

        $input = new XmlProcessor($fileName, $fileContent);
        $input->decode();
    }

    public function invalidFilesDataProvider(): \Generator
    {
        yield [__DIR__, ''];
        yield [__DIR__ . '/example.xml', ''];
        yield [__DIR__ . '/../resources/invalid.xml', ''];
    }

    public function test_fetch_and_output_data_as_csv(): void
    {
        $inputFileName = __DIR__ . '/../resources/coffee_feed.xml';
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $input = new XmlProcessor($inputFileName, file_get_contents($inputFileName));
        $output = new CsvProcessor($exportedFileName);
        $output->applyInput($input);

        $this->assertCount(3449, $output->getData());
    }
}
