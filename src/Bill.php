<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Alpenedv\Tools\Bcd;
use Alpenedv\Tools\Bcd\Exception\WrongCurrencyFormatException;
use Alpenedv\Tools\Bcd\Exception\WrongNumberException;
use Alpenedv\Tools\Bcd\Exception\WrongTextFormatException;
use Alpenedv\Tools\Bcd\Exception\WrongVersionException;

/**
 * Description of Bill
 *
 * @author eduard
 */
class Bill {
    
    const VERSION_1 = '001';
    const VERSION_2 = '002';
    
    const ENCODING_UTF8 = 1;
    //exception werfen wenn nicht utf8 is    
    private $version;
    private $decodingNumber;
    private $creditTransferMethod;
    private $bankIdentifierCode;
    private $recieverName;
    private $iban;
    private $amount;
    private $paymentReference;
    private $reasonForPayment;
    
    //check if length is the same aas in the docu 5
    // <editor-fold defaultstate="collapsed" desc="Setter">
        public function setVersion($version){
            if($version === self::VERSION_1 || $version === self::VERSION_2){
                $this->version=$version;
            }else {
                throw new WrongVersionException($version);
            }
        }
        public function setDecodingNumber($decodingNumber){
            if($decodingNumber>0&&$decodingNumber<9){
                $this->decodingNumber=$decodingNumber;
            }else{
                throw new WrongNumberException($decodingNumber);
            }
        }
        public function setCreditTransferMethod(string $creditTransferMethod) {
            if($creditTransferMethod=="SCT"||$creditTransferMethod=="SEPA"){
                $this->creditTransferMethod=$creditTransferMethod;
            }else{
                throw new WrongTextFormatException($creditTransferMethod.' is not a vaild TransferMethod;');
            }
            
            return $this;
        }
        public function setBankIdentiferCode($bic){
            if($this->version=="002"&&!empty($bic)){
                $this->bankIdentifierCode=$bic;
                return;
            }else if(empty ($bic)){
                throw new WrongTextFormatException($bic.'Bank Identifer Code is Not allowed to be empty in Version 001 current version '.$this->version);
            }else if($this->version=="001"){
                $this->bankIdentifierCode=$bic;
            }
        }
        public function setRecieverName($name){
            if(!empty($name)){
            $this->recieverName=$name;
            }
        }
        public function setIban(){
            // TODO: Mit Andi Die Lib verwenden
        }
        public function setAmount($amount){
            $value= substr($amount, 3);
            //Here is the check if it has a "," seperator or a currency seperator
            if(!is_numeric($value)){
                 throw new WrongCurrencyFormatException("Error: The Currency is not right or it has the wrong seperator use this seperator: .");
            }

            //NOT ALLOWED .0 .12 ...
            if($value[0]==".")
            {
                throw new WrongCurrencyFormatException("Error: Leading zero is required for amounts below 1 EUR.");
            }
            //NOT ALLOWED 00123.3 01.223 00000011 ....
            if($value[0]==0&&$value[1]!='.'){
                throw new WrongCurrencyFormatException("Error: There are no Zeros allowed Before the Euro Index");
            }
            //NOT ALLOWED 123.30 45.0
            if(strpos($value, '.')===true && $value[strlen($value)]==0){
                throw new WrongCurrencyFormatException("Error: There are no Zeros allowed at the end at The Currency");
            }
            
            if ($value <= 0) {
                throw new WrongCurrencyFormatException("Error: Currency Amount is too low");
            }
            
            if($value>999999999.99){
                throw new WrongCurrencyFormatException("Error: Currency Amount is greater as 999 999 999,99 Euro");
            }
            $this->amount =$amount;
        }
        public function setPaymentReference($ref){
            if(!empty($ref)){
                //TODO: Andi Fragen ob nicht pR mandatory sein sollte
               $this->paymentReference=$ref;
            }
        }
        public function setReasonForPayment($rfp){
            if(!empty($rfp)){
                $this->reasonForPayment=$rfp;
            }
        }
        // </editor-fold>
        
    // <editor-fold defaultstate="collapsed" desc="Getter">
       public function getVersion(){
           return $this ->version;
       }
       public function getDecodingNumber(){
           return $this-> decodingNumber;
       }
       public function getCreditTransferMethod(){
           return $this ->creditTransferMethod;
       }
       public function getBankIdentifierCode(){
           return $this ->bankIdentifierCode;
       }
       public function getRecieverName(){
           return $this ->recieverName;
       }
       public function getIban(){
           return $this ->iban;
       }
       public function getAmount(){
           return $this ->amount;
       }
       public function getPaymentReference(){
           return $this ->paymentReference;
       }
       public function getReasonForPayment(){
           return $this ->reasonForPayment;
       }
    // </editor-fold>
}
