<?php

namespace Tests;

use CSWeb\BIN\Environment;
use CSWeb\BIN\Http;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    public function testHttpComponent()
    {
        $env  = $this->getEnv();
        $http = new Http($env);

        $this->assertInstanceOf(Http::class, $http);
        $this->assertInstanceOf(Client::class, $http->getClient());
        $this->assertEquals('https://test.ipg-online.com/ipgapi/services', $http->baseUrl());
    }

    protected function getEnv(): Environment
    {
        $username = bin2hex(random_bytes(16));
        $password = bin2hex(random_bytes(16));
        $sslPass  = 123456;

        $sslCert = __DIR__ . '/fixtures/certs/private_key.pem';
        $sslKey  = __DIR__ . '/fixtures/certs/server.csr';

        return new Environment($username, $password, $sslCert, $sslKey, $sslPass, true);
    }
}
