<?php

namespace Tests\Transactions;

use CSWeb\BIN\Exceptions\NullTransactionParameters;
use CSWeb\BIN\Models\{
    CreditCardData,
    CreditCardType
};
use CSWeb\BIN\Transactions\{
    AbstractTransaction,
    Sale
};
use PHPUnit\Framework\TestCase;

class SaleTest extends TestCase
{
    public function testInstance()
    {
        $ccType = new CreditCardType(['type' => 'credit']);
        $ccData = new CreditCardData([
            'cardNumber'    => 411111111111,
            'expMonth'      => 12,
            'expYear'       => 30,
            'cardCodeValue' => 123
        ]);

        $sale = new Sale($ccType, $ccData);

        $xml = $sale->toXml();

        $this->assertInstanceOf(AbstractTransaction::class, $sale);
        $this->assertIsString($xml);
        $this->assertStringStartsWith('<?xml', $xml);
        $this->assertEquals(
            file_get_contents(__DIR__ . '/../fixtures/xml/new_sale.xml'),
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
