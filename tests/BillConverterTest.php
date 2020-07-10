<?php

namespace Alpenedv\Tools\Bcd\Tests;

use PHPUnit\Framework\TestCase;

use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\BillToStringConverter;
use Alpenedv\Tools\Bcd\Exception\WrongCurrencyFormatException;
use Alpenedv\Tools\Bcd\Exception\WrongNumberException;

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
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setBankIdentiferCode('GIBAATWW');
        $bill->setRecieverName('Max Mustermann');
        $bill->setIban('AT682011131032423628');
        $bill->setAmount('EUR1456.89');
        $bill->setPaymentReference('457845789452');
        $bill->setReasonForPayment('Diverse Autoteile, Re 789452 KN 457845');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/official-example-2.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
    
    /**
     * Test the BCD data generation, see doc example 2.
     */
    public function testConvertExample1()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $bill->setDecodingNumber(Bill::ENCODING_UTF8);
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setRecieverName('Umbrella Corp.');
        $bill->setIban('AT932236200123456789');
        $bill->setAmount('EUR1337.99');
        $bill->setPaymentReference('R2020/1938');
        $bill->setReasonForPayment('Handshakomat Über 3000');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/example-1.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
    public function testInValidConvertExample2()
    {
        
        $this->expectException(WrongNumberException::class);
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $bill->setDecodingNumber(2);
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setBankIdentiferCode('GENODEF1KIL');
        $bill->setRecieverName('Max Mustermann');
        $bill->setIban('DE52210900070088299309');
        $bill->setAmount('EUR1456.89');
        $bill->setPaymentReference('457845789452');
        $bill->setReasonForPayment('Diverse Autoteile, Re 789452 KN 457845');
        
        $converter = new BillToStringConverter();
    }
    public function testConvertExample3()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $bill->setDecodingNumber(1);
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setBankIdentiferCode('BICVXXDD123');
        $bill->setRecieverName('35 Zeichen langer Empfängername zum');
        $bill->setIban('XX17LandMitLangerIBAN2345678901234');
        $bill->setAmount('EUR12345689.01');
        $bill->setPaymentReference('35ZeichenLangeREFzurZuordnungBeimBe');
        $bill->setReasonForPayment('Netter Text für den Zahlenden, damit dieser weiß, was er zahlt und auc');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/example-3.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
    public function testConvertExample4()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $bill->setDecodingNumber(1);
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setBankIdentiferCode('GIBAATWW');
        $bill->setRecieverName('Max Mustermann');
        $bill->setIban('AT682011131032423628');
        $bill->setAmount('EUR1456.89');
        $bill->setPaymentReference('457845789452');
        $bill->setReasonForPayment('Diverse Autoteile, Re 789452 KN 457845');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/example-4.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
    public function testConvertExample5()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $bill->setDecodingNumber(1);
        $bill->setCreditTransferMethod(Bill::SCT);
        $bill->setRecieverName('35 Zeichen langer Empfängername zum');
        $bill->setIban('XX17LandMitLangerIBAN2345678901234');
        $bill->setAmount('EUR12345689.01');
        $bill->setPaymentReference('35ZeichenLangeREFzurZuordnungBeimBe');
        $bill->setReasonForPayment('Netter Text für den Zahlenden, damit dieser weiß, was er zahlt und auc');
        
        $expected = file_get_contents(__DIR__ . '/Fixtures/example-5.txt');
        
        $converter = new BillToStringConverter();
        $this->assertSame($expected, $converter->convert($bill));
    }
}