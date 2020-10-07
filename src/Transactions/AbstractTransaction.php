<?php

namespace CSWeb\BIN\Transactions;

use CSWeb\BIN\Exceptions\NullTransactionParameters;
use CSWeb\BIN\Interfaces\TransactionInterface;
use DOMDocument;

/**
 * AbstractTransaction
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Transactions
 */
abstract class AbstractTransaction implements TransactionInterface
{
    /**
     * @var DOMDocument
     */
    protected $soap;

    /**
     * @var array
     */
    protected $payload;

    /**
     * @var string|null
     */
    protected $prefix;

    public function __construct(array $payload = null, string $prefix = null)
    {
        if (is_null($payload)) {
            throw new NullTransactionParameters();
        }

        $this->payload = $payload;
        $this->prefix  = $prefix;

        $this->initializeSoap();
        $this->bootstrapAndTransformData();
    }

    public function initializeSoap()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;

        // Soap Env
        $envelope = $dom->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'SOAP-ENV:Envelope');

        // Soap Header
        $header = $dom->createElement('SOAP-ENV:Header');

        // Soap Body
        $body = $dom->createElement('SOAP-ENV:Body');

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

    public function bootstrapAndTransformData()
    {
        $transaction = $this->soap->getElementsByTagName($this->getRootNamespace())
                                  ->item(0);

        foreach ($this->payload as $key => $value) {
            $rootName = $this->getElementName($key);

            if (!is_array($value)) {
                $rootElement = $this->soap->createElement($rootName, $value);
            } else {
                $rootElement = $this->soap->createElement($rootName);

                foreach ($value as $child => $item) {
                    $childName = $this->getElementName($child);
                    $children  = $this->soap->createElement($childName, $item);

                    $rootElement->appendChild($children);
                }
            }

            $transaction->appendChild($rootElement);
        }
    }

    public function toXml(): string
    {
        return $this->soap->saveXML();
    }

    public function getElementName(string $element): string
    {
        return $this->prefix
            ? $this->prefix.':'.$element
            : $element;
    }
}
