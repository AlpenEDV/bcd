<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Alpenedv\Tools\Bcd;
/**
 * Description of BillToStringConverter
 *
 * @author eduard
 */
use Bill;
class BillToStringConverter {
    
    const CRLF = "\r\n";
    
    
    public function convert(Bill $bill): string
    {
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
    }
    
}
