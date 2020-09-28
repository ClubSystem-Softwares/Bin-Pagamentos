<?php

namespace CSWeb\BIN\Interfaces;

/**
 * TransactionInterface
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Interfaces
 */
interface TransactionInterface
{
    public function getRootNamespace() : string;

    public function toXml() : string;
}
