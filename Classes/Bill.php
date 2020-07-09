<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bill
 *
 * @author eduard
 */
class Bill {
    private $version;
    private $decodingNumber;
    private $creditTransferMethod;
    private $bankIdentifierCode;
    private $recieverName;
    private $iban;
    private $amount;
    private $paymentReference;
    private $reasonForPayment;
    
    // <editor-fold defaultstate="collapsed" desc="Setter">
        public function setVersion($version){
            if($version=="001"||$version=="002"){
                $this->version=$version;
            }else {
                throw new WrongVersionException($version);
            }
        }
        public function setDecodingNumber($decodingNumber){
            if($decodingNumber>0&&$decodingNumber<9){
                $this->decodingNumber=$decodingNumber;
            }else{
                throw new WrongNumberExcetion($decodingNumber);
            }
        }
        public function setCreditTransferMethod($creditTransferMethod) {
            if($creditTransferMethod=="SCT"||$creditTransferMethod=="SEPA"){
                $this->creditTransferMethod=$creditTransferMethod;
            }else{
                throw new WrongTextFormatException($creditTransferMethod.' is not a vaild TransferMethod;');
            }
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
            if(is_numeric($value)){
                //NOT ALLOWED .0 .12 ...
                if($value[0]==".")
                {
                    throw new WrongCurrencyFormatException("Error: No Euro Were Given at the Currency Setter");
                }
                //NOT ALLOWED 00123.3 01.223 00000011 ....
                if($value[0]==0&&$value[1]!='.'){
                    throw new WrongCurrencyFormatException("Error: There are no Zeros allowed Before the Euro Index");
                }
                //NOT ALLOWED 123.30 45.0
                if(strpos($value, '.')===true && $value[strlen($value)]==0){
                    throw new WrongCurrencyFormatException("Error: There are no Zeros allwoed at the end at The Currency");
                }
                if($value>999999999.99){
                    throw new WrongCurrencyFormatException("Error: Currency AMout is greater as 999 999 999,99 Euro");
                }
                $this->amount =$amount;
            }else {
                throw new WrongCurrencyFormatException("Error: The Currency is not right or it has the wrong seperator use this seperator: .");
            }
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
       public function getPaymentRefernce(){
           return $this ->paymentReference;
       }
       public function getReasonForPayment(){
           return $this ->reasonForPayment;
       }
    // </editor-fold>
}
