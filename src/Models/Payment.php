<?php

namespace CSWeb\BIN\Models;

/**
 * Payment
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
class Payment extends Model
{
    protected $prefix = 'v1';

    protected $namespace = 'Payment';

    protected $fillable = [
        'NumberOfInstallments',
        'ChargeTotal',
        'Currency'
    ];
}
