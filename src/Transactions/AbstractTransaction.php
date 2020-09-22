<?php

namespace CSWeb\BIN\Transactions;

use DOMDocument;

/**
 * AbstractTransaction
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Transactions
 */
abstract class AbstractTransaction
{
    /**
     * @var DOMDocument
     */
    protected $soap;

    public function __construct()
    {
        $this->initializeSoap();
    }

    public function initializeSoap()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;

        // Soap Env
        $envelope = $dom->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap-env:Envelope');

        // Soap Header
        $header = $dom->createElement('soap-env:Header');

        // Soap Body
        $body = $dom->createElement('soap-env:Body');

        $igapi = $dom->createElement('ipgapi:IPGApiOrderRequest');
        $igapi->setAttribute('xmlns:v1', 'http://ipg-online.com/ipgapi/schemas/v1');
        $igapi->setAttribute('xmlns:ipgapi', 'http://ipg-online.com/ipgapi/schemas/ipgapi');

        $baseElement = $dom->createElement($this->getRootNamespace());

        $igapi->appendChild($baseElement);
        $body->appendChild($igapi);

        $envelope->appendChild($header);
        $envelope->appendChild($body);
        $dom->appendChild($envelope);

        $this->soap = $dom;
    }

    public abstract function getRootNamespace(): string;

    public abstract function transformData();

    public function toXml() : string
    {
        return $this->soap->saveXML();
    }
}
