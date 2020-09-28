<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Interfaces\TransactionInterface;
use stdClass;

/**
 * BIN
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN
 */
class BIN
{
    protected $http;

    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    public function execute(TransactionInterface $transaction): stdClass
    {
        return $this->http->send($transaction);
    }
}
