<?php

namespace Tests;

use CSWeb\BIN\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Environment::class, new Environment());
    }
}
