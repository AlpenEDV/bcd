<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WrongCurrencyFormatException
 *
 * @author eduard
 */
class WrongCurrencyFormatException extends Exception{
    public function Message(){
        return $errorMsg=$this->getMessage();
    }
}
