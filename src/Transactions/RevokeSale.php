<?php

namespace CSWeb\BIN\Transactions;

/**
 * RevokeSale
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Transactions
 */
class RevokeSale extends AbstractTransaction
{
    public function getRootNamespace(): string
    {
        return 'v1:Transaction';
    }
}
