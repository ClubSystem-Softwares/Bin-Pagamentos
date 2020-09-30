<?php

namespace CSWeb\BIN\Traits;

use CSWeb\BIN\Models\{
    CreditCardData,
    CreditCardType,
    Payment,
    TransactionDetail
};
use CSWeb\BIN\Transactions\RevokeSale;
use CSWeb\BIN\Transactions\Sale;
use DateTime;

/**
 * InteractsWithSale
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\BIN\Traits
 */
trait InteractsWithSale
{
    public function sale(float $value, $orderId, string $cardNumber, DateTime $expiration, $cvv, $brand)
    {
        $payment  = new Payment(['chargeTotal' => $value, 'currency' => 986]);
        $details  = new TransactionDetail(['orderId' => $orderId]);
        $cardType = new CreditCardType(['type' => 'sale']);
        $cardData = new CreditCardData([
            'cardNumber'    => $cardNumber,
            'expMonth'      => $expiration->format('m'),
            'expYear'       => $expiration->format('Y'),
            'cardCodeValue' => $cvv,
            'brand'         => $brand
        ]);

        return $this->send(
            new Sale($cardType, $cardData, $details, $payment)
        );
    }

    public function revokeSale($orderId, $date)
    {
        $cardType = new CreditCardType(['type' => 'void']);
        $details  = new TransactionDetail(['orderId' => $orderId, 'tDate' => $date]);

        return $this->send(new RevokeSale($cardType, $details));
    }
}
