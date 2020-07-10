<?php

/*
 * BCD -Payment Qr Code Generation
 *
 * @copyright (c) AlpenEDV
 * @author Eduard Duanreanu <eduard@alpenedv.at>
 */
namespace Alpenedv\Tools\Bcd;

use Alpenedv\Tools\Bcd\Bill;

/**
 * Description of BillToStringConverter
 *
 * @author eduard
 */


class BillToStringConverter
{
    
    public const CRLF = "\r\n";
    public const BCD = "BCD";
    
    
    public function convert(Bill $bill): string
    {
          $output = "";
        if ($bill->getVersion() == $bill::VERSION_1) {
            $output = self::BCD . self::CRLF . $bill->getVersion() . self::CRLF
            . $bill->getDecodingNumber() . self::CRLF . $bill->getCreditTransferMethod()
            . self::CRLF . $bill->getBankIdentifierCode() . self::CRLF . $bill->getRecieverName() . self::CRLF
            . $bill->getIban() . self::CRLF . $bill->getAmount() . self::CRLF . self::CRLF
            . $bill->getPaymentReference() . self::CRLF . self::CRLF;
            if (!is_null($bill->getReasonForPayment())) {
                $output = $output . $bill->getReasonForPayment();
            }
        }
        if ($bill->getVersion() == $bill::VERSION_2) {
            $output = self::BCD . self::CRLF . $bill->getVersion() . self::CRLF
            . $bill->getDecodingNumber() . self::CRLF . $bill->getCreditTransferMethod() . self::CRLF;
            if (!is_null($bill->getBankIdentifierCode())) {
                $output = $output . $bill->getBankIdentifierCode() . self::CRLF;
            } else {
                $output = $output . self::CRLF;
            }
            $output = $output . $bill->getRecieverName() . self::CRLF
            . $bill->getIban() . self::CRLF . $bill->getAmount() . self::CRLF . self::CRLF
            . $bill->getPaymentReference() . self::CRLF . self::CRLF;
            if (!is_null($bill->getReasonForPayment())) {
                $output = $output . $bill->getReasonForPayment();
            }
        }
        return $output;
        /*
        $var="";
        if(empty($bill->getPaymentReference())&&empty($bill->getReasonForPayment())){
            //TODO: Error Handeling; if both are empty
        }
        if(empty($bill->getPaymentReference())){
            $var= $bill->getAmount()."Lf".$bill->getReasonForPayment();
        }else if (empty ($bill->getPaymentReference())){
            $var= $bill->getAmount()."Lf".$bill->getPaymentReference();
        }else {
            $var= $bill->getAmount()."Lf".$bill->getPaymentReference()."Lf".$bill->getReasonForPayment();
        }
        if(strlen($var)<=331){
            return $var;
        }else {
            //TODO: Error Handeling; if the byte is geater then 331 Byte
        }
         */
    }
}
