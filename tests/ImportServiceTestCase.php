<?php

namespace App\Tests;

use App\Services\Contracts\ImportServiceContract;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportServiceTestCase extends KernelTestCase
{
    protected ImportServiceContract $importService;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->importService = self::$container->get(ImportServiceContract::class);
    }
}