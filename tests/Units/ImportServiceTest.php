<?php

declare(strict_types=1);

namespace App\Tests\Units;

use App\Dtos\ImportDto;
use App\Processors\Concerns\Processor;
use App\Processors\CsvProcessor;
use App\Processors\XmlProcessor;
use App\Tests\ImportServiceTestCase;

class ImportServiceTest extends ImportServiceTestCase
{
    public function test_process_import_service(): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $inputProcessor = new XmlProcessor(__DIR__ . '/../resources/coffee_feed.xml');
        $outputProcessor = new CsvProcessor($exportedFileName);

        $this->importService->processImport($inputProcessor, $outputProcessor);

        $this->assertFileExists($exportedFileName);
        unlink($exportedFileName);
    }

    public function test_import_service(): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $importDto = new ImportDto(
            'xml',
            __DIR__ . '/../resources/coffee_feed.xml',
            'csv',
            $exportedFileName);
        $this->importService->import($importDto);

        $this->assertFileExists($exportedFileName);
        unlink($exportedFileName);
    }

    public function test_import_fails_on_phar_protocol(): void
    {
        $this->expectException(\RuntimeException::class);
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $importDto = new ImportDto(
            'xml',
            'phar://resources/coffee_feed.xml',
            'csv',
            $exportedFileName
        );
        $this->importService->import($importDto);
    }

    public function test_import_fails_on_empty_file(): void
    {
        $this->expectException(\RuntimeException::class);

        $importDto = new ImportDto(
            'xml',
            __DIR__ . '/../resources/coffee_feed.xml',
            'csv',
            'phar://resources/coffee_feed.xml'
        );
        $this->importService->import($importDto);
    }
}
