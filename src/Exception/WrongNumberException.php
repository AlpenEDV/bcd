<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Alpenedv\Tools\Bcd\Exception;

use Exception;

/**
 * Description of WrongNumberExcetion
 *
 * @author eduard
 */
class WrongNumberException extends Exception{
     public function Message(){
        return $errorMsg= 'Error: The Decoding Number '.$this->getMessage().'is not valid; (either is greater then 8 or lower then 1 or is not a number)';
    }
}
