<?php

namespace Tests\Models;

use CSWeb\BIN\Interfaces\ModelInterface;
use CSWeb\BIN\Models\CreditCardType;
use CSWeb\BIN\Models\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testModel()
    {
        $creditCardType = new CreditCardType([
            'type' => 'credit'
        ]);

        $forDom = $creditCardType->formatForDOM();

        $this->assertInstanceOf(ModelInterface::class, $creditCardType);
        $this->assertInstanceOf(Model::class, $creditCardType);
        $this->assertEquals('credit', $creditCardType->getAttribute('type'));
        $this->assertArrayHasKey('v1:CreditCardTxType', $forDom);
        $this->assertArrayHasKey('v1:Type', $forDom['v1:CreditCardTxType']);
        $this->assertEquals('credit', $forDom['v1:CreditCardTxType']['v1:Type']);
    }
}
