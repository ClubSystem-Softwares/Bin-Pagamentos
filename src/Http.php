<?php

namespace CSWeb\BIN;

use GuzzleHttp\Client;

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

    public function post()
    {
        $client = $this->getClient();
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
            ? 'https://test.ipg-online.com/ipgapi/services'
            : 'https://www2.ipg-online.com/ipgapi/services';
    }
}
