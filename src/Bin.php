<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\RequestException;
use CSWeb\BIN\Interfaces\TransactionInterface;
use CSWeb\BIN\Traits\InteractsWithSale;

/**
 * Bin
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Bin
 */
class Bin
{
    use InteractsWithSale;

    protected $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function send(TransactionInterface $transaction)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl()."services");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSLCERT, $this->env->getSslCert());
        curl_setopt($ch, CURLOPT_SSLKEY, $this->env->getSslKey());
        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $this->env->getSslPassword());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $transaction->toXml());

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
