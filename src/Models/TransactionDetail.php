<?php

namespace CSWeb\BIN\Models;

/**
 * TransactionDetail
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
class TransactionDetail extends Model
{
    protected $prefix = 'v1';

    protected $namespace = 'TransactionDetails';

    protected $fillable = [
        'OrderId',
        'TDate'
    ];
}
