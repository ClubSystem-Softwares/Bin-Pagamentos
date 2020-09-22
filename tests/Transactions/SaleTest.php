<?php

namespace Tests\Transactions;

use CSWeb\BIN\Transactions\AbstractTransaction;
use CSWeb\BIN\Transactions\Sale;
use PHPUnit\Framework\TestCase;

class SaleTest extends TestCase
{
    public function testInstance()
    {
        $sale = new Sale();
        $sale->transformData();

        $xml = $sale->toXml();

        $this->assertInstanceOf(AbstractTransaction::class, $sale);
        $this->assertIsString($xml);
        $this->assertStringStartsWith('<?xml', $xml);
    }
}
