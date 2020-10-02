<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\RequestException;
use CSWeb\BIN\Interfaces\TransactionInterface;
use CSWeb\BIN\Traits\InteractsWithSale;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\{
    ClientException,
    ServerException
};

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
        $client = new Client([
            'base_uri' => $this->baseUrl(),
            'auth'     => [
                $this->env->getUsername(),
                $this->env->getPassword()
            ],
            'curl'     => [
                CURLOPT_SSLCERT      => $this->env->getSslCert(),
                CURLOPT_SSLKEY       => $this->env->getSslKey(),
                CURLOPT_SSLKEYPASSWD => $this->env->getSslPassword(),
                CURLOPT_POSTFIELDS   => $transaction->toXml()
            ]
        ]);


        try {
            $response = $client->request('POST', 'services', [
                'headers' => [
                    'Content-Type' => 'application/xml'
                ]
            ]);

            $content  = $response->getBody()->getContents();

            return ContentParser::parse($content);
        } catch (ClientException | ServerException $e) {
            throw new RequestException('Aconteceu um erro durante a integração. Tente novamente', $e->getCode(), $e);
        }
    }

    public function baseUrl(): string
    {
        return $this->env->isSandbox()
            ? 'https://test.ipg-online.com/ipgapi/'
            : 'https://www2.ipg-online.com/ipgapi/';
    }
}
