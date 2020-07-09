<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
