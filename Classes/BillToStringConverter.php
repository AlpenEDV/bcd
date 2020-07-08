<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BillToStringConverter
 *
 * @author eduard
 */
class BillToStringConverter {
    private $amount;
    private $paymentReference;
    private $reasonForPayment;
    private $versionNumber;
    //TODO: Andi Fragen ob man die Codierungen so in mb_strlen benutzten kann.
    private $codierung= array('UTF-8','ISO-8895-1','ISO-8895-2','ISO-8895-4','ISO-8895-5','ISO-8895-7','ISO-8895-10','ISO-8895-15');
    
    public function setAmount($amount){
        if(empty($amount)){
            //TODO: Write New Exception
        throw new WrongCurrencyFormatException("Currency is not allowed to be empty");
        } else{
            $this->amount= $amount;
        }
    }
    public function setPaymentReference($PR){
        if(!empty($PR)){
            $this->paymentReference=$PR;
        }
    }
    public function setVersionNumber($version){
         $this->versionNumber=$version;
    }
    public function setReasonForPayment($RPF){
        if(!empty($RPF)){
            $this->reasonForPayment=$RPF;
        }
    }
    
    public function getFormatedString(){
        $var="";
        if(empty($this->paymentReference)&&empty($this->reasonForPayment)){
            //TODO: Error Handeling;
        }
        if(empty($this->paymentReference)){
            $var= $this->amount."Lf".$this->reasonForPayment;
        }else if (empty ($this->reasonForPayment)){
            $var= $this->amount."Lf".$this->reasonForPayment;
        }else {
            $var= $this->amount."Lf".$this->paymentReference."Lf".$this->reasonForPayment;
        }
        if(mb_strlen($var, $this->codierung[$this->versionNumber])<=331){
            return $var;
        }else {
            //TODO: Error Handeling;
        }
    }
    
}
