# BCD - Payment-QR-Code 

This library provides a simple way to create a payment QR-code e.g. for invoices conforming to the [EPC QR-Code standard](https://de.wikipedia.org/wiki/EPC-QR-Code).

## Advantages

  * Provides easy and convenient payment for users, reducing typos
  * Easy-to-use, object-oriented library
  * High test coverage
  * Open-Source (LGPL-3.0)

## Requirements

  * PHP 7.1 or higher
  * GD or Imagick extension for creating the QR-Code

## Installation

The recommended way to install the BCD library is via composer.

```json
"require": {
    "alpenedv/bcd": "0.2.*"
}
```

## Usage examples

```php
require_once('vendor/autoload.php');

use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\BillToStringConverter;

$bill = new Bill();
$bill->setVersion(Bill::VERSION_2); // optional, as version 2 is the default
$bill->setReceiverName('Umbrella Corp.');
$bill->setIban('AT932236200123456789');
$bill->setAmount('EUR1337.99');
$bill->setPaymentReference('R2020/1938');
$bill->setReasonForPayment('Handshakomat Über 3000');

$converter = new BillToStringConverter();
$qrText = $converter->convert($bill);
// The $qrText can now be used in any QR-code generation library, e.g. using TCPDFs barcodes.
```

## Tests

The test suite can be run with `vendor/bin/phpunit tests`.

## Contributing

Contributions to the BCD library are highly welcome. Please conform to the [PSR-12 coding standard](https://www.php-fig.org/psr/psr-12/) and provide tests for your code.
