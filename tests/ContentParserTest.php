<?php

namespace Tests;

use CSWeb\BIN\ContentParser;
use CSWeb\BIN\Exceptions\{
    InternalException,
    MerchantException,
    ProcessingException
};
use PHPUnit\Framework\TestCase;

class ContentParserTest extends TestCase
{
    public function testParseOfSuccessResponse()
    {
        $content = file_get_contents(__DIR__ . '/fixtures/xml/success_response.xml');

        $transaction = ContentParser::parse($content);

        $this->assertTrue($transaction->successfully);
    }

    public function testInternalException()
    {
        $this->expectException(InternalException::class);
        $this->expectExceptionMessage('Unexpected error');

        $content = file_get_contents(__DIR__ . '/fixtures/xml/internal_error.xml');

        ContentParser::parse($content);
    }

    public function testMerchantException()
    {
        $this->expectException(MerchantException::class);
        $this->expectExceptionMessage('Some error raised here');

        ContentParser::parse(
            file_get_contents(__DIR__ . '/fixtures/xml/merchant_error.xml')
        );
    }

    public function testProcessingError()
    {
        $this->expectException(ProcessingException::class);
        $this->expectExceptionMessage('Card expiry date exceeded');

        ContentParser::parse(
            file_get_contents(__DIR__ . '/fixtures/xml/processing_error.xml')
        );
    }

    public function testProcessingErrorWithMoreDetails()
    {
        $this->expectException(ProcessingException::class);
        $this->expectExceptionMessage('Duplicate transaction.');

        ContentParser::parse(
            file_get_contents(__DIR__ . '/fixtures/xml/processing_error_array.xml')
        );
    }
}
