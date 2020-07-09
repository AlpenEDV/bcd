<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Alpenedv\Tools\Bcd\Exception;

use Exception;

/**
 * Description of WrongTextFormatException
 *
 * @author eduard
 */
class WrongTextFormatException extends Exception{
     public function Message(){
        return $errorMsg=$this->getMessage();
    }
}
