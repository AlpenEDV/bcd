<?php

/*
 * BCD -Payment Qr Code Generation
 *
 * @copyright (c) AlpenEDV
 * @author Eduard Duanreanu <eduard@alpenedv.at>
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
class Bill
{
    public const VERSION_1 = '001';
    public const VERSION_2 = '002';
    public const SCT = 'SCT';
    public const ENCODING_UTF8 = 1;
    
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
    
    // <editor-fold defaultstate="collapsed" desc="Setter">
   //mb_strln == zeichen   strln=byte
    //TODO: CodeSytle PSR-12;
    public function setVersion(string $version)
    {
        if ($version === self::VERSION_1 || $version === self::VERSION_2) {
            $this->version = $version;
        } else {
            throw new WrongVersionException($version);
        }
        return $this;
    }
    public function setDecodingNumber(int $decodingNumber)
    {
        if ($decodingNumber != 1) {
            throw new WrongNumberException($decodingNumber);
        }
        $this->decodingNumber = $decodingNumber;

        return $this;
    }
    public function setCreditTransferMethod(string $creditTransferMethod)
    {
        if ($creditTransferMethod == self::SCT) {
            $this->creditTransferMethod = $creditTransferMethod;
        } else {
            throw new WrongTextFormatException($creditTransferMethod . ' is not a vaild TransferMethod;');
        }

        return $this;
    }
    public function setBankIdentiferCode(string $bic)
    {
        if (strlen($bic) != 8 && strlen($bic) != 11) {
            throw new WrongTextFormatException("Bank Identifier Code is not 8 Byte long or 11 Byte long.");
        }
        if (is_null($this->version)) {
            throw new WrongTextFormatException("Before setting the Bank Identifier Code please set the Verisonnumber.");
        }
        if ($this->version === self::VERSION_2 && !empty($bic)) {
            $this->bankIdentifierCode = $bic;
            return;
        } elseif (empty($bic)) {
            throw new WrongTextFormatException($bic
                    . 'Bank Identifer Code is Not allowed to be empty in Version 001 current version' . $this->version);
        }
            $this->bankIdentifierCode = $bic;
        return $this;
    }
    public function setRecieverName(string $name)
    {
        if (empty($name)) {
            throw new WrongTextFormatException("Error: The Reciever Name is not allowed to be empty.");
        }
        if (mb_strlen($name) > 70) {
            throw new WrongTextFormatException("Error: The Reciever Name is not allowed to be geater then 70 chars.");
        }

        $this->recieverName = $name;
        return $this;
    }
    public function setIban(string $iban)
    {
        // TODO: Mit Andi Die Lib verwenden
        if (empty($iban)) {
            throw new WrongTextFormatException("Error: The Iban is not allowed to be empty.");
        }
        if (strlen($iban) > 34) {
            throw new WrongTextFormatException("Error: The Iban is not allowed to be Greater then 34 chars.");
        }
        $this->iban = $iban;
        return $this;
    }
    //TODO: Amount länge einstellen.
    public function setAmount(string $amount)
    {
        
        $value = substr($amount, 3);
        if (strlen($value) > 34) {
            throw new WrongCurrencyFormatException("Error: The Currenzy is not allowed to be greater then 34 Byte.");
        }
        //Here is the check if it has a "," seperator or a currency seperator
        if (!is_numeric($value)) {
            throw new WrongCurrencyFormatException("Error: The Currency is not right or it has the wrong seperator use "
                    . "this seperator: .");
        }

        //NOT ALLOWED .0 .12 ...
        if ($value[0] == ".") {
            throw new WrongCurrencyFormatException("Error: Leading zero is required for amounts below 1 EUR.");
        }
        //NOT ALLOWED 00123.3 01.223 00000011 ....
        if ($value[0] == 0 && $value[1] != '.') {
            throw new WrongCurrencyFormatException("Error: There are no Zeros allowed Before the Euro Index");
        }
        //NOT ALLOWED 123.30 45.0
        if (strpos($value, '.') !== false && $value[strlen($value) - 1] == 0) {
            throw new WrongCurrencyFormatException("Error: There are no Zeros allowed at the end at The Currency");
        }

        if ($value[strlen($value) - 1] == '.') {
            throw new WrongCurrencyFormatException("Error: There is no Seperation operator allowed at the end.");
        }

        if ($value <= 0) {
            throw new WrongCurrencyFormatException("Error: Currency Amount is too low");
        }

        if ($value > 999999999.99) {
            throw new WrongCurrencyFormatException("Error: Currency Amount is greater as 999 999 999,99 Euro");
        }
        $this->amount = $amount;
        return $this;
    }
    public function setPaymentReference(string $ref)
    {
        if (empty($ref)) {
            throw new WrongTextFormatException("Error: The PaymentReference is not allowed to be Empty.");
        }
        if (strlen($ref) > 35) {
            throw new WrongTextFormatException("Error: The PaymentReference is not allowed to be greater "
                    . "then 35 Byte.");
        }
           $this->paymentReference = $ref;
        return $this;
    }
    public function setReasonForPayment(string $rfp)
    {
        if (empty($rfp)) {
            //Reason for Payment is Optional
            return;
        }
        if (mb_strlen($rfp) > 140) {
            throw new WrongTextFormatException("Error: The Reason for Payment is not allowed to be "
                    . "longer then 140 Chars.");
        }
         $this->reasonForPayment = $rfp;
        return $this;
    }
        // </editor-fold>
        
    // <editor-fold defaultstate="collapsed" desc="Getter">
    public function getVersion()
    {
        return $this ->version;
    }
    public function getDecodingNumber()
    {
        return $this-> decodingNumber;
    }
    public function getCreditTransferMethod()
    {
        return $this ->creditTransferMethod;
    }
    public function getBankIdentifierCode()
    {
        return $this ->bankIdentifierCode;
    }
    public function getRecieverName()
    {
        return $this ->recieverName;
    }
    public function getIban()
    {
        return $this ->iban;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getPaymentReference()
    {
        return $this ->paymentReference;
    }
    public function getReasonForPayment()
    {
        return $this ->reasonForPayment;
    }
    // </editor-fold>
}
