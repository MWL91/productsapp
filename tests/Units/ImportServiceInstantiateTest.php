<?php

namespace App\Tests\Units;

use App\Inputs\XmlInput;
use App\Outputs\CsvOutput;
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
        $this->assertInstanceOf(XmlInput::class, $this->importService->getInputProcessor('xml'));
    }

    public function test_can_get_csv_output_processor(): void
    {
        $this->assertInstanceOf(CsvOutput::class, $this->importService->getOutputProcessor('csv'));
    }

    public function test_can_not_get_not_existing_processor(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->importService->getOutputProcessor('not_existing');
    }
}
