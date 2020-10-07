<?php

namespace CSWeb\BIN\Transactions;

/**
 * Sale
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Transactions
 */
class Sale extends AbstractTransaction
{
    public function getRootNamespace(): string
    {
        return 'v1:Transaction';
    }
}
