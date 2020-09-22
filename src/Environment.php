<?php

namespace CSWeb\BIN;

use InvalidArgumentException;

/**
 * Environment
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN
 */
class Environment
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $sslCert;

    /**
     * @var string
     */
    protected $sslKey;

    /**
     * @var string
     */
    protected $sslPassword;

    public function __construct(
        string $username,
        string $password,
        string $sslCert,
        string $sslKey,
        string $sslPassword
    ) {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setSslCert($sslCert);
        $this->setSslKey($sslKey);
        $this->setSslPassword($sslPassword);
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function setUsername(string $username) : Environment
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password) : Environment
    {
        $this->password = $password;

        return $this;
    }

    public function getSslCert() : string
    {
        return $this->sslCert;
    }

    public function setSslCert(string $sslCert) : Environment
    {
        if (!is_file($sslCert)) {
            throw new InvalidArgumentException('SSL cert is not a file');
        }

        $this->sslCert = $sslCert;

        return $this;
    }

    public function getSslKey() : string
    {
        return $this->sslKey;
    }

    public function setSslKey(string $sslKey) : Environment
    {
        if (!is_file($sslKey)) {
            throw new InvalidArgumentException('SSL key is not a file');
        }

        $this->sslKey = $sslKey;

        return $this;
    }

    public function getSslPassword() : string
    {
        return $this->sslPassword;
    }

    public function setSslPassword(string $sslPassword) : Environment
    {
        $this->sslPassword = $sslPassword;

        return $this;
    }
}
