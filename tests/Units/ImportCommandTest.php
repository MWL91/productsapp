<?php

namespace App\Tests\Units;

use App\Command\ImportCommand;
use App\Inputs\Concerns\InputContract;
use App\Outputs\Concerns\OutputContract;
use App\Services\Contracts\ImportServiceContract;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery;

class ImportCommandTest extends TestCase
{
    public function test_command_success(): void
    {
        $importServiceMock = Mockery::mock(ImportServiceContract::class)
            ->shouldReceive([
                'getInputProcessor' => Mockery::mock(InputContract::class),
                'getOutputProcessor' => Mockery::mock(OutputContract::class),
                'import' => null,
            ])
            ->getMock();

        $commandTest = new CommandTester(new ImportCommand($importServiceMock));

        $this->assertEquals(Command::SUCCESS, $commandTest->execute([
            'file' => 'example.xml'
        ]));
    }

    public function test_command_withoutProcessor(): void
    {
        $importServiceMock = Mockery::mock(ImportServiceContract::class);
        $importServiceMock->shouldReceive('getInputProcessor')->andThrow(\RuntimeException::class);
        $importServiceMock->shouldReceive('getOutputProcessor')->andThrow(\RuntimeException::class);
        $importServiceMock->shouldReceive('import')->andReturn(null);

        $commandTest = new CommandTester(new ImportCommand($importServiceMock));

        $this->assertEquals(Command::INVALID, $commandTest->execute([
            'file' => 'example.xml'
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

        (new CommandTester(new ImportCommand($importServiceMock)))->execute([]);
    }
}
