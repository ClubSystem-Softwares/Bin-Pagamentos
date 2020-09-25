<?php

namespace Tests\XML;

use CSWeb\BIN\XML\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParserInstance()
    {
        $parser = new Parser($this->getFileContent());

        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function testParserResponseMethods()
    {
        $parser = new Parser($this->getFileContent());

        $this->assertJson($parser->toJson());
        $this->assertIsArray($parser->toArray());
        $this->assertInstanceOf(\stdClass::class, $parser->toObject());

        $this->assertArrayHasKey('IPGApiActionResponse', $parser->toArray());
    }

    public function testElementExtraction()
    {
        $parser = new Parser($this->getFileContent());
        $response = $parser->pathToExtract('IPGApiActionResponse')->toArray();

        $this->assertArrayHasKey('successfully', $response);
    }

    protected function getFileContent() : string
    {
        return file_get_contents(__DIR__ . '/../fixtures/xml/success_response.xml');
    }
}
