<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WrongNumberExcetion
 *
 * @author eduard
 */
class WrongNumberExcetion extends Exception{
     public function Message(){
        return $errorMsg= 'Error: The Decoding Number '.$this->getMessage().'is not vaild; (either is greater then 8 or lower then 1 or is not a number)';
    }
}
