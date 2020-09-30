<?php

namespace Tests\Transactions;

use CSWeb\BIN\Models\CreditCardType;
use CSWeb\BIN\Models\TransactionDetail;
use CSWeb\BIN\Transactions\AbstractTransaction;
use CSWeb\BIN\Transactions\RevokeSale;
use PHPUnit\Framework\TestCase;

class RevokeSaleTest extends TestCase
{
    public function testInstance()
    {
        $creditCardType     = new CreditCardType(['type' => 'void']);
        $transactionDetails = new TransactionDetail([
            'orderId' => 1,
            'tDate'   => 1190244932
        ]);

        $revokeSale = new RevokeSale($creditCardType, $transactionDetails);

        $xml = $revokeSale->toXml();

        $this->assertInstanceOf(AbstractTransaction::class, $revokeSale);
        $this->assertIsString($xml);
        $this->assertStringStartsWith('<?xml', $xml);
        $this->assertEquals(
            file_get_contents(__DIR__ . '/../fixtures/xml/revoke_sale.xml'),
            $xml
        );
    }
}
