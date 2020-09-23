<?php

namespace CSWeb\BIN\Models;

/**
 * CreditCardType
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
class CreditCardType extends Model
{
    protected $namespace = 'CreditCardTxType';

    protected $prefix = 'v1';

    protected $fillable = [
        'Type'
    ];
}
