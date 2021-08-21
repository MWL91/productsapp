<?php

namespace App\Tests\Units;

use App\Processors\CsvProcessor;
use App\Processors\XmlProcessor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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
        $input = new XmlProcessor(__DIR__ . '/../resources/coffee_feed.xml');
        $input->fetch();

        $this->assertCount(3449, $input->getData());
        $this->assertIsString($input->getContent());
    }

    /**
     * @dataProvider invalidFilesDataProvider
     */
    public function test_fetch_data_from_xml_input_when_invalid_file(string $fileName): void
    {
        $this->expectException(\RuntimeException::class);

        $input = new XmlProcessor($fileName);
        $input->fetch();
    }

    public function invalidFilesDataProvider(): \Generator
    {
        yield [__DIR__];
        yield [__DIR__ . '/example.xml'];
        yield [__DIR__ . '/../resources/invalid.xml'];
    }

    public function test_fetch_and_store_data_as_csv(): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $input = new XmlProcessor(__DIR__ . '/../resources/coffee_feed.xml');
        $input->fetch();

        $output = new CsvProcessor($exportedFileName);
        $output->setData($input->getData());
        $output->store();

        $this->assertFileExists($exportedFileName);
        unlink($exportedFileName);
    }
}
