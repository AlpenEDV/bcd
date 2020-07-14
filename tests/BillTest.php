<?php

namespace Alpenedv\Tools\Bcd\Tests;

use PHPUnit\Framework\TestCase;
use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\Exception\WrongCurrencyFormatException;
use Alpenedv\Tools\Bcd\Exception\WrongVersionException;
use Alpenedv\Tools\Bcd\Exception\WrongNumberException;
use Alpenedv\Tools\Bcd\Exception\WrongTextFormatException;

class BillTest extends TestCase
{
    public function testNoCurrency()
    {
        $this->expectException(WrongCurrencyFormatException::class);
        //@codingStandardsIgnoreStart
        $this->expectExceptionMessage('Error: The Currency is not right or it has the wrong seperator use this seperator: .');
        //@codingStandardsIgnoreEnd
        $bill = new Bill();
        $bill->setAmount('EUR12x345');
    }
    
    public function testValidVerisonNumber1()
    {
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_1);
        $this->assertSame(Bill::VERSION_1, $bill->getVersion());
    }
    
    public function testValidVerisonNumber2()
    {
       
        $bill = new Bill();
        $bill->setVersion(Bill::VERSION_2);
        $this->assertSame(Bill::VERSION_2, $bill->getVersion());
    }
    
    public function testInValidVerisonNumber()
    {
        $this->expectException(WrongVersionException::class);
        $bill = new Bill();
        $bill->setVersion(3);
    }
    
    public function testValidDecodingNumberUsingUtf8()
    {
        $bill = new Bill();
        $bill->setDecodingNumber(Bill::ENCODING_UTF8);
        $this->assertSame(Bill::ENCODING_UTF8, $bill->getDecodingNumber());
    }
    
    public function testValidDecodingNumberUsing1()
    {
        $bill = new Bill();
        $bill->setDecodingNumber(1);
        $this->assertSame(1, $bill->getDecodingNumber());
    }
    
    public function testInValidDecodingNumber()
    {
        $this->expectException(WrongNumberException::class);
        $bill = new Bill();
        $bill->setDecodingNumber(3);
    }
    
    public function testValidCreditTransferMethod()
    {
        $bill = new Bill();
        $bill->setCreditTransferMethod(Bill::SCT);
        $this->assertSame(Bill::SCT, $bill->getCreditTransferMethod());
    }
    
    public function testInValidCreditTransferMehod()
    {
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setCreditTransferMethod('ACD');
    }
    
    public function testValidBankIdentiferCode8Byte()
    {
        $bill = new Bill();
        $bic = 'z37c5387';
        $bill->setVersion(Bill::VERSION_1)
        ->setBankIdentiferCode($bic);
        $this->assertSame($bic, $bill->getBankIdentifierCode());
    }
    
    public function testValidBankIdentiferCode11Byte()
    {
        
        $bic = 'z37c5387jt1';
        
        $bill = (new Bill())
            ->setVersion(Bill::VERSION_1)
            ->setBankIdentiferCode($bic)
        ;
         
        $this->assertSame($bic, $bill->getBankIdentifierCode());
    }
    
    public function testInvalidBankIdentiferCodewhereversionisnotGiven()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $this->expectExceptionMessage('Before setting the Bank Identifier Code please set the Verisonnumber.');
        $bill->setBankIdentiferCode('z37c53872');
    }
    
    public function testInvalidBankIdentiferCodeIsTooLong()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $this->expectExceptionMessage('Bank Identifier Code is not 8 Byte long or 11 Byte long.');
        $bill->setVersion(Bill::VERSION_1)
            ->setBankIdentiferCode('z37c538722222223124314');
    }
    
    public function testInvalidBankIdentiferCodewhereBICisEmpty()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $this->expectExceptionMessage('Bank Identifer Code is Not allowed to be empty in Version 001 current version'
                . $bill->getVersion());
        $bill->setVersion(Bill::VERSION_1);
        $bill->setBankIdentiferCode('');
    }
    
    public function testInvalidBankIdentiferCodewhereversionis1butBicisnotGiven()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $bill->setVersion(Bill::VERSION_1);
        $bill ->setBankIdentiferCode('');
    }
    
    public function testValidRecieverName()
    {
       
        $bill = new Bill();
        $bill->setReceiverName('Helmiut Müller');
        $this->assertSame('Helmiut Müller', $bill->getRecieverName());
    }
    
    public function testInValidRecieverNameWhereNameisToLong()
    {
       
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setReceiverName('ACDkjjmjhvahsvdjhavjhfgajhgf jhqabvjhavkhfkbakjfbakjabkjfbakjbakfbkjabf');
    }
    
    public function testInValidRecieverNameWhereNameisempty()
    {
       
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setReceiverName('');
    }
    
    public function testValidIban()
    {
       
        $bill = new Bill();
        $bill->setIban('AT932236200123456789');
        $this->assertSame('AT932236200123456789', $bill->getIban());
    }
    
    public function testInValidIbanWhereIbanisToLong()
    {
       
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setIban('AT93223620012345678987287634872873654872676236487');
    }
    
    public function testInValidIbanWhereIbanisempty()
    {
       
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setIban('');
    }
    
    public function testValidReasonForPayment()
    {
        $bill = new Bill();
        $bill->setReasonForPayment('Du Andi Ich bin glaube ich fertig mit dem Testen');
        $this->assertSame('Du Andi Ich bin glaube ich fertig mit dem Testen', $bill->getReasonForPayment());
    }
    
    public function testInvalidReasonForPaymentwhererfpistolong()
    {
        $this->expectException(WrongTextFormatException::class);
        $bill = new Bill();
        $bill->setReasonForPayment('hgaahhahhahsfdapokfajnfkjhabzfguzgauzgdqiuwhdoijqpokcomakjncjhwagfuztgasbfdnk'
                . 'jahoifhqiuagwiuzrgakjnfuazuzfgaihfpoiquoinakjsncjahiuzgrfancjkpoakduqanwlma'
                . 'pock8zqarfiunalkkf9aurzannnnn,h');
    }
    
    public function testValidUserNote()
    {
        $bill = new Bill();
        $bill->setUserNote('danke Für Ihren Einkauf');
        $this->assertSame('danke Für Ihren Einkauf', $bill->getUserNote());
    }
    
    public function testInValidUserNoteTooLong()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $bill->setUserNote(str_repeat('X', 71));
    }
    /**
     * @param string $amount
     *
     * @dataProvider validAmountsProvider
     */
    public function testValidCurrencyAmounts(string $amount)
    {
        $bill = new Bill();
        $bill->setAmount($amount);
        $this->assertSame($amount, $bill->getAmount());
    }
    
    public function testUserNote()
    {
        $bill = new Bill();
        
        $this->assertSame($bill, $bill->setUserNote(''));
    }
    
    public function testReasonForPaymentReturnThis()
    {
        $bill = new Bill();
        
        $this->assertSame($bill, $bill->setReasonForPayment(''));
    }
    
    public function testPaymentReferneceEmpty()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $bill->setPaymentReference('');
    }
    
    public function testPaymentReferneceTooLong()
    {
        $bill = new Bill();
        $this->expectException(WrongTextFormatException::class);
        $bill->setPaymentReference(str_repeat('X', 36));
    }
    
    
    /**
     * @param string $amount
     *
     * @dataProvider invalidAmountsProvider
     */
    public function testInvalidCurrencyAmounts(string $amount)
    {
        $bill = new Bill();
        $this->expectException(WrongCurrencyFormatException::class);
        $bill->setAmount($amount);
    }
    
    public function validAmountsProvider()
    {
        return [
            ['EUR0.01'],
            ['EUR0.2'],
            ['EUR0.97'],
            ['EUR45'],
            ['EUR184.6'],
            ['EUR58723.01'],
            ['EUR999999999.99'],
        ];
    }
    public function invalidAmountsProvider()
    {
        return [
            ['EUR.01'],
            ['EUR.2'],
            ['EUR.97'],
            ['EUR45.'],
            ['EUR45.0'],
            ['EUR45.00'],
            ['EUR000045.'],
            ['EUR184.60'],
            ['EUR000184.60'],
            ['EUR184,6'],
            ['EUR000058723.01'],
            ['EUR999.999.999,99'],
            ['EUR1999999999.99'],
            ['EUR999999999,99'],
            ['EUR99999999999999999999999999999.99'],
            ['EUR-0.3'],
        ];
    }
}
