<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\InternalException;
use CSWeb\BIN\Exceptions\MerchantException;
use CSWeb\BIN\Exceptions\ProcessingException;
use CSWeb\BIN\XML\Parser;
use stdClass;

/**
 * ContentParser
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN
 */
class ContentParser
{
    public static function parse(string $xml): stdClass
    {
        $content = (new Parser($xml))->toObject();

        if (property_exists($content, 'Fault')) {
            $fault = $content->Fault;

            $faultCode   = trim($fault->faultcode);
            $faultString = trim($fault->faultstring);

            $detail = property_exists($fault, 'detail') ? $fault->detail : null;

            if ($faultCode == 'Server') {
                throw new InternalException(ucfirst($faultString));
            }

            if ($faultString == 'MerchantException') {
                throw new MerchantException(trim($detail));
            }

            if (preg_match('/ProcessingException:/i', $faultString)) {
                throw new ProcessingException(
                    trim($detail->IPGApiOrderResponse->ProcessorResponseMessage)
                );
            }
        }

        return $content;
    }
}
