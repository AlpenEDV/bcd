<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('vendor/autoload.php');

$bill = new Alpenedv\Tools\Bcd\Bill();
$bill->setAmount(333.88);

var_dump($bill);
