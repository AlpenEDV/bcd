<?php

/**
 * BCD -Payment Qr Code Generation
 *
 * @copyright (c) AlpenEDV
 * @author Eduard Duanreanu <eduard@alpenedv.at>
*/

namespace Alpenedv\Tools\Bcd;

use Alpenedv\Tools\Bcd\Bill;
use Alpenedv\Tools\Bcd\Exception\WrongTextFormatException;

/**
 * Converts the Porperty from the Bill class to a long string
 * @author eduard
 */
class BillToStringConverter
{
    
    public const CRLF = "\r\n";
    public const BCD = 'BCD';
    
    
    public function convert(Bill $bill): string
    {
        //Check for Invalid Versions see: Pages 5 & 6
        $output = '';
        if ($bill->getVersion() === $bill::VERSION_1) {
            $output = self::BCD . self::CRLF . $bill->getVersion() . self::CRLF
            . $bill->getDecodingNumber() . self::CRLF . $bill->getCreditTransferMethod()
            . self::CRLF . $bill->getBankIdentifierCode() . self::CRLF . $bill->getRecieverName() . self::CRLF
            . $bill->getIban() . self::CRLF . $bill->getAmount() . self::CRLF . self::CRLF
            . $bill->getPaymentReference() . self::CRLF . self::CRLF;
            if (!is_null($bill->getReasonForPayment())) {
                $output .= $bill->getReasonForPayment();
            }
            if (!is_null($bill->getUserNote())) {
                $output .= self::CRLF . self::CRLF . $bill->getUserNote();
            }
        }
        if ($bill->getVersion() === $bill::VERSION_2) {
            $output = self::BCD . self::CRLF . $bill->getVersion() . self::CRLF
            . $bill->getDecodingNumber() . self::CRLF . $bill->getCreditTransferMethod() . self::CRLF;
            if (!is_null($bill->getBankIdentifierCode())) {
                $output .= $bill->getBankIdentifierCode() . self::CRLF;
            } else {
                $output .= self::CRLF;
            }
            $output = $output . $bill->getRecieverName() . self::CRLF
            . $bill->getIban() . self::CRLF . $bill->getAmount() . self::CRLF . self::CRLF
            . $bill->getPaymentReference() . self::CRLF . self::CRLF;
            if (!is_null($bill->getReasonForPayment())) {
                $output .= $bill->getReasonForPayment();
            }
            if (!is_null($bill->getUserNote())) {
                $output .= self::CRLF . self::CRLF . $bill->getUserNote();
            }
        }
        if (strlen($output) >= 331) {
            throw new WrongTextFormatException('The Output String is not allowed to be longer then 331 Bytes.');
        }
        
        return $output;
    }
}
