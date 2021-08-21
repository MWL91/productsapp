<?php

declare(strict_types=1);

namespace App\Tests\Units;

use App\Processors\CsvProcessor;
use App\Processors\XmlProcessor;
use App\Services\ImportService;
use App\Tests\ImportServiceTestCase;

class ImportServiceInstantiateTest extends ImportServiceTestCase
{
    public function test_instantiate_service(): void
    {
        $this->assertInstanceOf(ImportService::class, $this->importService);
    }

    public function test_can_get_xml_input_processor(): void
    {
        $this->assertInstanceOf(XmlProcessor::class, $this->importService->getProcessor('xml', 'example.xml'));
    }

    public function test_can_get_csv_output_processor(): void
    {
        $this->assertInstanceOf(CsvProcessor::class, $this->importService->getProcessor('csv', 'example.csv'));
    }

    public function test_can_not_get_not_existing_processor(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->importService->getProcessor('not_existing', 'none');
    }
}
