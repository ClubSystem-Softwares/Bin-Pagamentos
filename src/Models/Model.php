<?php

namespace CSWeb\BIN\Models;

use CSWeb\BIN\Interfaces\ModelInterface;
use InvalidArgumentException;

/**
 * Model
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Models
 */
abstract class Model implements ModelInterface
{
    protected $namespace = null;

    protected $prefix = null;

    protected $attributes;

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->fill($data);
        }

        if (!$this->checkIfNamespaceExists()) {
            throw new InvalidArgumentException('Model XML namespace not setted');
        }
    }

    protected function checkIfNamespaceExists(): bool
    {
        return !is_null($this->namespace);
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->attributes[$this->getAttributeName($attribute)] = $value;
        }
    }

    public function getAttribute(string $key)
    {
        $key = $this->getAttributeName($key);

        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return null;
    }

    public function setAttribute(string $key, $value)
    {
        $this->attributes[$this->getAttributeName($key)] = $value;
    }

    protected function getAttributeName($attribute): string
    {
        return mb_convert_case($attribute, MB_CASE_TITLE);
    }

    public function formatForDOM(): array
    {
        $prefix    = ($this->prefix) ? $this->prefix . ':' : null;
        $namespace = $prefix . $this->namespace;

        $data[$namespace] = [];

        foreach ($this->attributes as $attribute => $value) {
            $data[$namespace][$prefix . $attribute] = $value;
        }

        return $data;
    }
}
