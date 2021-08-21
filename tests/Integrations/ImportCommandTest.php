<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Command\ImportCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    public function commandInputDataProvider()
    {
        /**
         * IMPORTANT NOTE:
         *
         * This test case is insecure!
         * However I assume, that this credentials are open.
         *
         * Normally it could be stored in .env file, but for this case I've just make an exception.
         */
        yield ['ftp://pupDev:pupDev2018@transport.productsup.io/coffee_feed.xml', 3449, 'csv'];

        yield [__DIR__ . '/../resources/coffee_feed.xml', 3449, 'csv'];
    }

    /**
     * @dataProvider commandInputDataProvider
     */
    public function test_command_success(string $inputFile, int $count, string $exportType): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.' . $exportType;

        $command = self::$container->get(ImportCommand::class);
        $exec = (new CommandTester($command))->execute([
            'inputFile' => $inputFile,
            'outputFile' => $exportedFileName,
        ]);

        $encoders = [new CsvEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $payload = file_get_contents($exportedFileName);
        $data = $serializer->decode($payload, $exportType);

        $this->assertEquals(Command::SUCCESS, $exec);
        $this->assertFileExists($exportedFileName);
        $this->assertCount($count, $data);

        unlink($exportedFileName);
    }

    public function test_command_fail_when_input_not_readable(): void
    {
        $command = self::$container->get(ImportCommand::class);
        $commandTest = new CommandTester($command);

        $this->assertEquals(Command::FAILURE, $commandTest->execute([
            'inputFile' => 'input.xml',
            'outputFile' => 'output.xml',
        ]));
    }
}
