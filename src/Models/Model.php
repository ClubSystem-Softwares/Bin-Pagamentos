<?php

namespace CSWeb\BIN\Models;

/**
 * Model
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
abstract class Model
{
    public $namespace;

    public abstract function getNamespace();
}
