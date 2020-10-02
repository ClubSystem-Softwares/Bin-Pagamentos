<?php

namespace CSWeb\BIN\Transactions;

use CSWeb\BIN\Exceptions\NullTransactionParameters;
use CSWeb\BIN\Interfaces\ModelInterface;
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
     * @var ModelInterface[]
     */
    protected $models = [];

    public function __construct(ModelInterface ...$models)
    {
        if (empty($models)) {
            throw new NullTransactionParameters();
        }

        foreach ($models as $model) {
            array_push($this->models, $model);
        }

        $this->bootstrapAndTransformModels();
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

    public function bootstrapAndTransformModels()
    {
        $this->initializeSoap();

        $transaction = $this->soap->getElementsByTagName($this->getRootNamespace())
                                  ->item(0);

        foreach ($this->models as $element) {
            $elementData = $element->formatForDOM();

            foreach ($elementData as $root => $children) {
                $rootElement = $this->soap->createElement($root);

                foreach ($children as $key => $value) {
                    $childrenElement = $this->soap->createElement($key, $value);
                    $rootElement->appendChild($childrenElement);
                }

                $transaction->appendChild($rootElement);
            }
        }
    }

    public function toXml(): string
    {
        return $this->soap->saveXML();
    }
}
