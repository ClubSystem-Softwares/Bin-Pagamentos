<?php

namespace CSWeb\BIN\Transactions;

use RuntimeException;

/**
 * Sale
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Transactions
 */
class Sale extends AbstractTransaction
{
    protected $data;

    public function __construct()
    {
        parent::__construct();

        //CreditCardTxType/
            //Type

        //CreditCardData/
            // CardNumber
            // ExpMonth
            // ExpYear
            // CardCodeValue

        //Payment
            //numberOfInstallments
            //ChargeTotal
            //Currency

        //TransactionDetails
            //OrderId
    }

    public function getRootNamespace(): string
    {
        return 'v1:Transaction';
    }

    public function transformData()
    {
        $transaction = $this->soap->getElementsByTagName($this->getRootNamespace())
                                  ->item(0);

        if (is_null($transaction)) {
            throw new RuntimeException('An error occurred during DOM\'s element search');
        }

        $ccType = $this->soap->createElement('v1:CreditCardTxType');
        $store  = $this->soap->createElement('v1:StoreId', 2724189910);
        $type   = $this->soap->createElement('v1:Type', 'sale');

        $ccType->appendChild($store);
        $ccType->appendChild($type);

        $transaction->appendChild($ccType);

        return $this;
    }
}
