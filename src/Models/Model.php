<?php

namespace CSWeb\BIN\Models;

use CSWeb\BIN\Exceptions\MassAssignException;
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

    protected $fillable = [];

    protected $setterCasting = [];

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
            $attribute = $this->getAttributeName($attribute);

            if (!$this->isFillable($attribute)) {
                throw new MassAssignException(
                    sprintf('The attribute [%s] is not marked as fillable in [%s]', $attribute, get_class($this))
                );
            }

            $this->setAttributeValue($attribute, $value);
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
        $this->fill([$key => $value]);
    }

    protected function getAttributeName($attribute): string
    {
        return ucwords($attribute);
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

    public function isFillable($key): bool
    {
        return in_array($key, $this->fillable);
    }

    public function getSetterCasting(string $key): ?string
    {
        if (empty($this->setterCasting) || !array_key_exists($key, $this->setterCasting)) {
            return null;
        }

        return $this->setterCasting[$key];
    }

    public function setAttributeValue($attribute, $value)
    {
        $value = $this->castValue(
            $this->getSetterCasting($attribute), $value
        );

        $this->attributes[$attribute] = $value;
    }

    protected function castValue(?string $cast, $value)
    {
        switch ($cast) {
            case 'int':
                return (int)$value;
            case 'float':
                return (float)$value;
            case 'bool':
                return (bool)$value;
            default:
                return $value;
        }
    }
}
