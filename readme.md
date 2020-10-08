CSWeb BIN Pagamentos
===

#### Testes
Para a realização de alguns testes, é necessário o uso de certificados
digitais. Para este package foram gerados alguns certificados
auto-assinados, que se encontram em `tests/fixtures/certs`.

A senha do certificado `private_key.pem` é muito simples: *123456*

Estes certificados tem validade de 4 anos.
Caso deseja gerar outros, faça

```bash
# generate private key and enter pass phrase
openssl genrsa -des3 -out private_key.pem 2048

# create certificate signing request, enter "*.example.com" as a "Common Name", leave "challenge password" blank
openssl req -new -sha256 -key private_key.pem -out server.csr

# generate self-signed certificate for 1 year
openssl req -x509 -sha256 -days 365 -key private_key.pem -in server.csr -out server.pem

# validate the certificate
openssl req -in server.csr -text -noout | grep -i "Signature.*SHA256" && echo "All is well" || echo "This certificate doesn't work in 2017! You must update OpenSSL to generate a widely-compatible certificate"
```

#### Criando uma nova venda

Para Criação de uma nova venda, faça

```php
<?php

require_once __DIR__ . './vendor/autoload.php';

use CSWeb\BIN\Environment;
use CSWeb\BIN\Transactions\Sale;
use CSWeb\BIN\Bin;

$payload = [
    'CreditCardTxType' => [
        'Type' => 'sale'
    ],
    'CreditCardData'   => [
        'CardNumber'    => 411111111111,
        'ExpMonth'      => 12,
        'ExpYear'       => 30,
        'CardCodeValue' => 123
    ],
    'Payment' => [
        'NumberOfInstallments' => 1, // Opcional
        'ChargeTotal'          => 10.0,
        'Currency'             => 986 // REAL formato ISO
    ],
    'TransactionDetails' => [
        'OrderId',
        'TDate'
    ],
    'cardFunction' => 'credit'
];

$sale = new Sale($payload, 'v1');
$env  = new Environment('username', 'password', 'path/to/cert', 'path/to/key', 'ssl_key');

$bin = new Bin($env);

$response = $bin->send($sale);
```

