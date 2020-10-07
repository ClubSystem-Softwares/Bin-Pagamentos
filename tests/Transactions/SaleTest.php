<?php

namespace Tests\Transactions;

use CSWeb\BIN\Exceptions\NullTransactionParameters;
use CSWeb\BIN\Transactions\{
    AbstractTransaction,
    Sale
};
use PHPUnit\Framework\TestCase;

class SaleTest extends TestCase
{
    public function testInstance()
    {
        $payload = [
            'CreditCardTxType' => [
                'Type' => 'credit'
            ],
            'CreditCardData'   => [
                'CardNumber'    => 411111111111,
                'ExpMonth'      => 12,
                'ExpYear'       => 30,
                'CardCodeValue' => 123
            ]
        ];

        $sale = new Sale($payload, 'v1');
        $xml  = $sale->toXml();

        $this->assertInstanceOf(AbstractTransaction::class, $sale);
        $this->assertIsString($xml);
        $this->assertStringStartsWith('<?xml', $xml);
        $this->assertEquals(
            file_get_contents(__DIR__.'/../fixtures/xml/new_sale.xml'),
            $xml
        );
    }

    public function testFailedConstructor()
    {
        $this->expectException(NullTransactionParameters::class);
        $this->expectExceptionMessage('Missing Transaction parameters');

        $sale = new Sale();
    }
}
