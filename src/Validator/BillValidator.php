<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Alpenedv\Tools\Bcd\Validator;
use Symfony\Component\Validator\ConstraintValidator;
use Alpenedv\Tools\Bcd\Bill;
/**
 * Description of BillValidator
 *
 * @author eduard
 */
class BillValidator  extends ConstraintValidator{
    //put your code here
    public function validate(Bill $bill,Constraint $constraint) {
        //TODO: Build Constraint
        //$bill->addPropertyConstraint('version', new \Symfony\Component\Validator\Constraints\NotBlank());
    }
    
}
