<?php

namespace CSWeb\BIN\XML;

use stdClass;

/**
 * Parser
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\XML
 * @see https://joshtronic.com/2014/07/13/parsing-soap-responses-with-simplexml/
 */
class Parser
{
    protected $xml;

    public function __construct(string $xml)
    {
        $toRemove = [
            'SOAP-ENV:',
            'ipgapi:',
            'a1:',
            'v1:'
        ];

        $this->xml = simplexml_load_string(
            strtolower(str_replace($toRemove, '', $xml))
        );
    }

    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }

    public function toJson(): string
    {
        return json_encode($this->xml);
    }

    public function toObject(): stdClass
    {
        return json_decode($this->toJson());
    }
}

