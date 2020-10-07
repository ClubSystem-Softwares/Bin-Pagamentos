<?php

namespace Tests\Transactions;

use CSWeb\BIN\Transactions\AbstractTransaction;
use CSWeb\BIN\Transactions\RevokeSale;
use PHPUnit\Framework\TestCase;

class RevokeSaleTest extends TestCase
{
    public function testInstance()
    {
        $payload = [
            'CreditCardTxType'   => [
                'Type' => 'void'
            ],
            'TransactionDetails' => [
                'OrderId' => 1,
                'TDate'   => 1190244932
            ]
        ];

        $revokeSale = new RevokeSale($payload, 'v1');

        $xml = $revokeSale->toXml();

        $this->assertInstanceOf(AbstractTransaction::class, $revokeSale);
        $this->assertIsString($xml);
        $this->assertStringStartsWith('<?xml', $xml);
        $this->assertEquals(
            file_get_contents(__DIR__.'/../fixtures/xml/revoke_sale.xml'),
            $xml
        );
    }
}
