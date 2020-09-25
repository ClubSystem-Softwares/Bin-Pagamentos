<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\RequestException;
use CSWeb\BIN\Transactions\AbstractTransaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

/**
 * Http
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN
 */
class Http
{
    /**
     * @var Environment
     */
    protected $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function send(AbstractTransaction $transaction)
    {
        $client  = $this->getClient();
        $request = new Request('POST', 'services', [
            'Content-Type' => 'application/xml'
        ], $transaction->toXml());

        try {
            $response = $client->send($request);

            $content = $response->getBody()->getContents();

            return ContentParser::parse($content);

        } catch (ClientException | ServerException $e) {
            throw new RequestException('An error ocurred during the request', $e->getCode(), $e);
        }
    }

    public function getClient(): Client
    {
        return new Client([
            'base_url' => $this->baseUrl(),
            'auth'     => [
                $this->env->getUsername(),
                $this->env->getPassword()
            ],
            'curl'     => [
                CURLOPT_SSLCERT      => $this->env->getSslCert(),
                CURLOPT_SSLKEY       => $this->env->getSslKey(),
                CURLOPT_SSLKEYPASSWD => $this->env->getSslPassword()
            ]
        ]);
    }

    public function baseUrl(): string
    {
        return $this->env->isSandbox()
            ? 'https://test.ipg-online.com/ipgapi'
            : 'https://www2.ipg-online.com/ipgapi';
    }
}
