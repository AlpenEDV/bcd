<?php

/*
 * BCD -Payment Qr Code Generation 
 * 
 * @copyright (c) AlpenEDV
 * @author Eduard Duanreanu <eduard@alpenedv.at>
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
        return $errorMsg= 'Error: The Decoding Number '.$this->getMessage().'is not valid;';
    }
}
