<?php

namespace CSWeb\BIN\Exceptions;

/**
 * NullTransactionParameters
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Exceptions
 */
class NullTransactionParameters extends \InvalidArgumentException
{
    protected $message = 'Missing Transaction parameters';
}
