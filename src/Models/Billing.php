<?php

namespace CSWeb\BIN\Models;

/**
 * Billing
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
class Billing extends Model
{
    protected $prefix = 'v1';

    protected $namespace = 'Billing';

    protected $fillable = [
        'CustomerID',
        'Name',
        'Company',
        'Address1',
        'Address2',
        'City',
        'State',
        'Zip',
        'Country',
        'Phone',
        'Fax',
        'Email'
    ];
}
