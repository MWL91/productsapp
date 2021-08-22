<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Command\ImportCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    public function commandInputDataProvider(): \Generator
    {
        /**
         * IMPORTANT NOTE:
         *
         * This test case is insecure!
         * However I assume, that this credentials are open.
         *
         * Normally it could be stored in .env file, but for this case I've just make an exception.
         */
        yield ['ftp://pupDev:pupDev2018@transport.productsup.io/coffee_feed.xml', 3449, 'xml', 'csv'];

        yield [__DIR__ . '/../resources/coffee_feed.xml', 3449, 'xml', 'csv'];

        yield [__DIR__ . '/../../phpunit.xml.dist', 1, 'xml', 'csv'];

        yield [__DIR__ . '/../resources/data.csv', 3449, 'csv', 'xml'];
    }

    /**
     * @dataProvider commandInputDataProvider
     */
    public function test_command_success(string $inputFile, int $count, string $inputType, string $outputType): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.' . $outputType;

        $command = self::$container->get(ImportCommand::class);
        $exec = (new CommandTester($command))->execute([
            'inputFile' => $inputFile,
            'outputFile' => $exportedFileName,
            '--inputFormat' => $inputType,
            '--outputFormat' => $outputType
        ]);

        $encoders = [new CsvEncoder(), new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $payload = file_get_contents($exportedFileName);
        $data = $serializer->decode($payload, $outputType);

        $this->assertEquals(Command::SUCCESS, $exec);
        $this->assertFileExists($exportedFileName);
        $this->assertCount($count, $data);

        unlink($exportedFileName);
    }

    public function commandInvalidInputDataProvider(): \Generator
    {
        yield [
            [
                'inputFile' => 'input.xml',
                'outputFile' => 'output.xml',
            ]
        ];

        yield [
            [
                'inputFile' => 'phar://.env.test',
                'outputFile' => 'output.xml',
            ]
        ];
    }

    /**
     * @dataProvider commandInvalidInputDataProvider
     */
    public function test_command_failure(array $input): void
    {
        $command = self::$container->get(ImportCommand::class);
        $commandTest = new CommandTester($command);

        $this->assertEquals(Command::FAILURE, $commandTest->execute($input));
    }
}
