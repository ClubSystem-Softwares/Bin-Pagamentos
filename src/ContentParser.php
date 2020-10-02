<?php

namespace CSWeb\BIN;

use CSWeb\BIN\Exceptions\{
    InternalException,
    MerchantException,
    ProcessingException
};
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
        if ( static::isJson($xml) ) {
            $content = json_decode($xml, true);

            if (isset($content['message'])) {
                throw new MerchantException($content['message']);
            }
        }

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
                $message = is_array($detail)
                    ? $detail[0]->IPGApiOrderResponse->ErrorMessage
                    : $detail->IPGApiOrderResponse->ErrorMessage;

                throw new ProcessingException(trim($message));
            }
        }

        return $content->IPGApiActionResponse;
    }

    public static function isJson($content): bool
    {
        json_decode($content);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
