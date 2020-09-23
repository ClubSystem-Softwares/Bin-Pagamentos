<?php

namespace CSWeb\BIN\Models;

/**
 * CreditCardData
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
class CreditCardData extends Model
{
    protected $prefix = 'v1';

    protected $namespace = 'CreditCardData';

    protected $fillable = [
        'CardNumber',
        'ExpMonth',
        'ExpYear',
        'CardCodeValue'
    ];
}
