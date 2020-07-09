<?php

namespace Alpenedv\Tools\Bcd\Tests;

use PHPUnit\Framework\TestCase;

use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\BillToStringConverter;
use Alpenedv\Tools\Bcd\Exception\WrongCurrencyFormatException;

class BillToStringConverterTest extends TestCase
{
    /**
     * Test the BCD data generation, see doc example 2.
     */
    public function testConvertOfficialExample2()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_1);
        $bill->setDecodingNumber(Bill::ENCODING_UTF8);
        $bill->setBankIdentiferCode('GIBAATWW');
        $bill->setRecieverName('Max Mustermann');
        $bill->setIban('AT682011131032423628');
        $bill->setAmount('EUR1456.89');
        $bill->setPaymentReference('457845789452');
        $bill->setReasonForPayment('Diverse Autoteile, Re 789452 KN 457845');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/official-example2.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
    
    /**
     * Test the BCD data generation, see doc example 2.
     */
    public function testConvertExample1()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_1);
        $bill->setDecodingNumber(Bill::ENCODING_UTF8);
        $bill->setBankIdentiferCode('RZTIAT22363');
        $bill->setRecieverName('Umbrella Corp.');
        $bill->setIban('AT932236200123456789');
        $bill->setAmount('EUR1337.99');
        $bill->setPaymentReference('R2020/1938');
        $bill->setReasonForPayment('Handshakomat 3000');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/example1.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
}