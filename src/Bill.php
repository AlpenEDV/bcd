<?php

/**
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
 * Bill saves every Property
 * @author eduard
 */
class Bill
{
    public const VERSION_1 = '001';
    public const VERSION_2 = '002';
    public const SCT = 'SCT';
    public const ENCODING_UTF8 = 1;

    private $version = self::VERSION_2;
    private $decodingNumber = self::ENCODING_UTF8;
    private $creditTransferMethod = self::SCT;
    private $bankIdentifierCode;
    private $receiverName;
    private $iban;
    private $amount;
    private $paymentReference;
    private $reasonForPayment;
    private $userNote;

    // <editor-fold defaultstate="collapsed" desc="Setter">

    public function setVersion(string $version)
    {
        if ($version === self::VERSION_1 || $version === self::VERSION_2) {
            $this->version = $version;
        } else {
            throw new WrongVersionException('Error the Version Number ' . $version . ' is not valid');
        }
        return $this;
    }
    public function setDecodingNumber(int $decodingNumber)
    {
        if ($decodingNumber !== 1) {
            throw new WrongNumberException('Error: The Decoding Number ' . $decodingNumber . ' is not valid;');
        }
        $this->decodingNumber = $decodingNumber;

        return $this;
    }
    public function setCreditTransferMethod(string $creditTransferMethod)
    {
        if ($creditTransferMethod === self::SCT) {
            $this->creditTransferMethod = $creditTransferMethod;
        } else {
            throw new WrongTextFormatException($creditTransferMethod . ' is not a valid TransferMethod;');
        }

        return $this;
    }
    public function setBankIdentiferCode(string $bic)
    {
        if (!empty($bic) && strlen($bic) !== 8 && strlen($bic) !== 11) {
            throw new WrongTextFormatException('Bank Identifier Code is not 8 Byte long or 11 Byte long.');
        }

        if ($this->version === self::VERSION_2 && !empty($bic)) {
            $this->bankIdentifierCode = $bic;

            return $this;
        }

        if (empty($bic)) {
            throw new WrongTextFormatException('Bank Identifer Code is not allowed to be empty in Version 001 current '
                    . 'version ' . $this->version);
        }

        $this->bankIdentifierCode = $bic;

        return $this;
    }
    public function setReceiverName(string $name)
    {
        if (empty($name)) {
            throw new WrongTextFormatException('Error: The Receiver Name is not allowed to be empty.');
        }
        // mb_strlen == characters, strlen == bytes
        if (mb_strlen($name) > 70) {
            throw new WrongTextFormatException('Error: The Receiver Name is not allowed to be longer than 70 chars.');
        }

        $this->receiverName = $name;

        return $this;
    }
    public function setIban(string $iban)
    {
        if (empty($iban)) {
            throw new WrongTextFormatException('Error: The IBAN is not allowed to be empty.');
        }

        if (strlen($iban) > 34) {
            throw new WrongTextFormatException('Error: The IBAN is not allowed to be longer than 34 chars.');
        }
        $this->iban = $iban;

        return $this;
    }
    //Invalid see: Page 6
    public function setAmount(string $amount)
    {
        $value = substr($amount, 3);
        if (strlen($amount) > 34) {
            throw new WrongCurrencyFormatException('Error: The Currency is not allowed to be longer than 34 Bytes.');
        }

        //Here is the check if it has a ',' seperator or a currency seperator
        if (!is_numeric($value)) {
            throw new WrongCurrencyFormatException('Error: The Currency is not right or it has the wrong seperator use '
                    . 'this seperator: .');
        }

        //NOT ALLOWED .0 .12 ...
        if ($value[0] === '.') {
            throw new WrongCurrencyFormatException('Error: Leading zero is required for amounts below 1 EUR.');
        }

        //NOT ALLOWED 00123.3 01.223 00000011 ....
        if ($value[0] === '0' && $value[1] !== '.') {
            throw new WrongCurrencyFormatException('Error: There are no zeros allowed Before the Euro Index');
        }

        //NOT ALLOWED 123.30 45.0
        if (strpos($value, '.') !== false && $value[strlen($value) - 1] === '0') {
            throw new WrongCurrencyFormatException('Error: There are no zeros allowed at the end of the Currency');
        }

        if ($value[strlen($value) - 1] === '.') {
            throw new WrongCurrencyFormatException('Error: There is no Seperation operator allowed at the end.');
        }

        if ($value <= 0) {
            throw new WrongCurrencyFormatException('Error: Currency Amount is too low');
        }

        if ($value > 999999999.99) {
            throw new WrongCurrencyFormatException('Error: Currency Amount is greater as 999 999 999,99 Euro');
        }
        $this->amount = $amount;

        return $this;
    }
    public function setPaymentReference(string $ref)
    {
        if (empty($ref)) {
            throw new WrongTextFormatException('Error: The PaymentReference is not allowed to be Empty.');
        }
        if (strlen($ref) > 35) {
            throw new WrongTextFormatException('Error: The PaymentReference is not allowed to be longer '
                    . 'than 35 Bytes.');
        }
        $this->paymentReference = $ref;

        return $this;
    }
    public function setReasonForPayment(string $rfp)
    {
        if (empty($rfp)) {
            //Reason for Payment is Optional
            return $this;
        }
        if (mb_strlen($rfp) > 140) {
            throw new WrongTextFormatException('Error: The Reason for Payment is not allowed to be '
                    . 'longer than 140 Chars.');
        }
        $this->reasonForPayment = $rfp;

        return $this;
    }
    public function setUserNote(string $note)
    {
        if (empty($note)) {
            //User Note is Optional
            return $this;
        }
        if (mb_strlen($note) > 70) {
            throw new WrongTextFormatException('Error: User Note is not allowed to be longer than 70 Chars.');
        }
        $this->userNote = $note;

        return $this;
    }
        // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter">
    public function getVersion(): ?string
    {
        return $this ->version;
    }
    public function getDecodingNumber(): int
    {
        return $this-> decodingNumber;
    }
    public function getCreditTransferMethod(): string
    {
        return $this ->creditTransferMethod;
    }
    public function getBankIdentifierCode(): ?string
    {
        return $this ->bankIdentifierCode;
    }
    public function getRecieverName(): string
    {
        return $this ->receiverName;
    }
    public function getIban(): string
    {
        return $this ->iban;
    }
    public function getAmount(): string
    {
        return $this->amount;
    }
    public function getPaymentReference(): ?string
    {
        return $this ->paymentReference;
    }
    public function getReasonForPayment(): ?string
    {
        return $this ->reasonForPayment;
    }
    public function getUserNote(): ?string
    {
        return $this->userNote;
    }
    // </editor-fold>
}
