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
 * Description of WrongVersionException
 *
 * @author eduard
 */
class WrongVersionException extends Exception{
    public function Message(){
        return $errorMsg= 'Error the Version Number '.$this->getMessage().'is not vaild';
    }
}
