<?php

namespace CSWeb\BIN\Transactions;

use RuntimeException;

class Sale extends AbstractTransaction
{
    public function transformData()
    {
        $dom = $this->soap;

        $transaction = $dom->getElementsByTagName($this->getRootNamespace())->item(0);

        if (is_null($transaction)) {
            throw new RuntimeException('An error occurred during DOM\'s element search');
        }

        $ccType = $dom->createElement('v1:CreditCardTxType');
        $store  = $dom->createElement('v1:StoreId', 2724189910);
        $type   = $dom->createElement('v1:Type', 'sale');

        $ccType->appendChild($store);
        $ccType->appendChild($type);

        $transaction->appendChild($ccType);

        return $this;
    }

    public function getRootNamespace(): string
    {
        return 'v1:Transaction';
    }
}
