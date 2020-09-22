<?php

namespace Tests;

use CSWeb\BIN\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInstance()
    {
        $username = $this->username();
        $password = $this->password();
        $sslPass  = $this->sslPassword();

        $sslCert = __DIR__ . '/fixtures/certs/private_key.pem';
        $sslKey  = __DIR__ . '/fixtures/certs/server.csr';

        $environment = new Environment($username, $password, $sslCert, $sslKey, $sslPass);

        $this->assertInstanceOf(Environment::class, $environment);
        $this->assertEquals($username, $environment->getUsername());
        $this->assertEquals($password, $environment->getPassword());
        $this->assertEquals($sslPass, $environment->getSslPassword());
        $this->assertEquals($sslCert, $environment->getSslCert());
        $this->assertEquals($sslKey, $environment->getSslKey());
    }

    public function testInvalidCertFile()
    {
        $this->expectExceptionMessage('SSL cert is not a file');

        $username = $this->username();
        $password = $this->password();
        $sslPass  = $this->sslPassword();

        $sslCert = __DIR__ . '/fixtures/certs/invalid_file.pem';
        $sslKey  = __DIR__ . '/fixtures/certs/server.csr';

        $environment = new Environment($username, $password, $sslCert, $sslKey, $sslPass);
    }

    public function testInvalidKeyFile()
    {
        $this->expectExceptionMessage('SSL key is not a file');

        $username = $this->username();
        $password = $this->password();
        $sslPass  = $this->sslPassword();

        $sslCert = __DIR__ . '/fixtures/certs/private_key.pem';
        $sslKey  = __DIR__ . '/fixtures/certs/invalid_file.csr';

        $environment = new Environment($username, $password, $sslCert, $sslKey, $sslPass);
    }

    protected function username() : string
    {
        return $this->randomKey();
    }

    protected function password() : string
    {
        return $this->randomKey();
    }

    protected function sslPassword() : string
    {
        return $this->randomKey();
    }

    protected function randomKey() : string
    {
        return bin2hex(random_bytes(16));
    }
}
