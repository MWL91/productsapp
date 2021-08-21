<?php

declare(strict_types=1);

namespace App\Tests\Units;

use App\Processors\CsvProcessor;
use App\Processors\XmlProcessor;
use App\Tests\ImportServiceTestCase;

class ImportServiceTest extends ImportServiceTestCase
{
    public function test_import_service(): void
    {
        $exportedFileName = __DIR__ . '/../resources/' . time() . '.csv';

        $inputProcessor = new XmlProcessor(__DIR__ . '/../resources/coffee_feed.xml');
        $outputProcessor = new CsvProcessor($exportedFileName);

        $this->importService->processImport($inputProcessor, $outputProcessor);

        $this->assertFileExists($exportedFileName);
        unlink($exportedFileName);
    }
}
