<?php

namespace Alpenedv\Tools\Bcd\Tests;

use PHPUnit\Framework\TestCase;

use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\Exception\WrongCurrencyFormatException;

class BillTest extends TestCase
{
    public function testNoCurrency()
    {
        $this->expectException(WrongCurrencyFormatException::class);
        $this->expectExceptionMessage('Error: The Currency is not right or it has the wrong seperator use this seperator: .');
        $bill = new Bill();
        $bill->setAmount('EUR12x345');
    }
    
    /**
     * @param string $amount
     * 
     * @dataProvider validAmountsProvider
     */
    public function testValidCurrencyAmounts(string$amount)
    {
        $bill = new Bill();
        $bill->setAmount($amount);
        $this->assertSame($amount, $bill->getAmount());
    }
    
    /**
     * @param string $amount
     * 
     * @dataProvider invalidAmountsProvider
     */
    public function testInvalidCurrencyAmounts(string$amount)
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
            ['EUR45.'],
            ['EUR45.0'],
            ['EUR45.00'],
            ['EUR000045.'],
            ['EUR184.60'],
            ['EUR000184.60'],
            ['EUR184,6'],
            ['EUR000058723.01'],
            ['EUR999.999.999,99'],
            ['EUR999999999,99'],
        ];
    }
}