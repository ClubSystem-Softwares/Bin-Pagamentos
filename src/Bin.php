<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\RequestException;
use CSWeb\BIN\Interfaces\TransactionInterface;

/**
 * Bin
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Bin
 */
class Bin
{
    protected $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function send(TransactionInterface $transaction)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->baseUrl()."services",
            CURLOPT_POST           => 1,
            CURLOPT_HTTPHEADER     => ["Content-Type: text/xml"],
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => $this->env->getUsername().':'.$this->env->getPassword(),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSLCERT        => $this->env->getSslCert(),
            CURLOPT_SSLKEY         => $this->env->getSslKey(),
            CURLOPT_SSLKEYPASSWD   => $this->env->getSslPassword(),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS     => $transaction->toXml()
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            throw new RequestException(
                sprintf('Ocorreu um erro durante a requisição: cURL - %d (%s)', curl_errno($ch), curl_error($ch))
            );
        }

        return ContentParser::parse($response);
    }

    public function baseUrl(): string
    {
        return $this->env->isSandbox()
            ? 'https://test.ipg-online.com/ipgapi/'
            : 'https://www2.ipg-online.com/ipgapi/';
    }
}
