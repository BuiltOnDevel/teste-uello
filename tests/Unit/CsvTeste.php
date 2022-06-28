<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CsvTeste extends TestCase
{
    public function type_file()
    {
        $csvFile = new CsvController($file,$head,$delimiter);
        $csvFile->readFile();
        $this->assertTrue(true);
    }
}
