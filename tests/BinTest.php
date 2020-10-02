<?php

namespace Tests;

use CSWeb\BIN\Environment;
use CSWeb\BIN\Bin;
use PHPUnit\Framework\TestCase;

class BinTest extends TestCase
{
    public function testHttpComponent()
    {
        $env  = $this->getEnv();
        $http = new Bin($env);

        $this->assertInstanceOf(Bin::class, $http);
        $this->assertEquals('https://test.ipg-online.com/ipgapi/', $http->baseUrl());
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
