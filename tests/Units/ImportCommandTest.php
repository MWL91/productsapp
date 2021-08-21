<?php

declare(strict_types=1);

namespace App\Tests\Units;

use App\Command\ImportCommand;
use App\Processors\Concerns\InputProcessorContract;
use App\Services\Contracts\ImportServiceContract;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCommandTest extends TestCase
{
    public function test_command_success(): void
    {
        $importServiceMock = Mockery::mock(ImportServiceContract::class)
            ->shouldReceive([
                'import' => Mockery::mock(InputProcessorContract::class)
                    ->shouldReceive([
                        'getFilename' => 'output.xml'
                    ])
                    ->getMock(),
            ])
            ->getMock();

        $commandTest = new CommandTester(new ImportCommand($importServiceMock, Mockery::mock(LoggerInterface::class)));

        $this->assertEquals(Command::SUCCESS, $commandTest->execute([
            'inputFile' => 'input.xml',
            'outputFile' => 'output.xml',
        ]));
    }

    public function test_command_withoutProcessor(): void
    {
        $importServiceMock = Mockery::mock(ImportServiceContract::class);
        $importServiceMock->shouldReceive('import')->andThrow(\RuntimeException::class);

        $commandTest = new CommandTester(new ImportCommand($importServiceMock, Mockery::mock(LoggerInterface::class)->shouldReceive(['error' => null])->getMock()));

        $this->assertEquals(Command::FAILURE, $commandTest->execute([
            'inputFile' => 'input.xml',
            'outputFile' => 'output.xml',
        ]));
    }

    public function test_command_fail_without_file_input(): void
    {
        $this->expectException(\RuntimeException::class);

        $importServiceMock = Mockery::mock(ImportServiceContract::class)
            ->shouldReceive([
                'inputFormatExists' => true,
                'outputFormatExists' => true,
                'import' => null,
            ])
            ->getMock();

        (new CommandTester(new ImportCommand($importServiceMock, Mockery::mock(LoggerInterface::class))))->execute([]);
    }
}
