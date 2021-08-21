<?php

namespace App\Tests\Units;

use App\Inputs\XmlInput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlInputTest extends KernelTestCase
{
    public function test_use_serializer(): void
    {
        self::bootKernel();

        $encoders = [new XmlEncoder(), new JsonEncoder(), new CsvEncoder()];
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
        $input = new XmlInput();
        $input->fetch(__DIR__ . '/../resources/coffee_feed.xml');

        $this->assertCount(3449, $input->getData());
    }

    /**
     * @dataProvider invalidFilesDataProvider
     */
    public function test_fetch_data_from_xml_input_when_invalid_file(string $fileName): void
    {
        $this->expectException(\RuntimeException::class);

        $input = new XmlInput();
        $input->fetch($fileName);
    }

    public function invalidFilesDataProvider(): \Generator
    {
        yield [__DIR__];
        yield [__DIR__ . '/example.xml'];
        yield [__DIR__ . '/../resources/invalid.xml'];
    }
}
