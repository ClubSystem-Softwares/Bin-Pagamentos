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

    protected $pathToExtract = null;

    protected $removeFromXML = ['SOAP-ENV:', 'ipgapi:', 'a1:', 'v1:'];

    public function __construct(string $xml, $pathToExtract = null)
    {
        $this->pathToExtract($pathToExtract);

        $this->xml = simplexml_load_string(
            str_replace($this->removeFromXML, '', $xml)
        );
    }

    public function pathToExtract(?string $pathToExtract): Parser
    {
        $this->pathToExtract = $pathToExtract;

        return $this;
    }

    public function getBaseObject()
    {
        return ($this->pathToExtract)
            ? $this->xml->Body->{$this->pathToExtract}
            : $this->xml->Body;
    }

    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }

    public function toJson(): string
    {
        return json_encode($this->getBaseObject());
    }

    public function toObject(): stdClass
    {
        return json_decode($this->toJson());
    }
}

