<?php

namespace CSWeb\BIN\Interfaces;

/**
 * ModelInterface
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Interfaces
 */
interface ModelInterface
{
    public function fill(array $attributes);

    public function getAttribute(string $key);

    public function setAttribute(string $key, $value);

    public function formatForDOM(): array;
}
