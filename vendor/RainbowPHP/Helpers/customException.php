<?php
namespace RainbowPHP\Helpers;
use App\Config\Config_sys;
class customException extends Exception
 {
 public function errorMessage()
  {
  $env = Config_sys::$env;

  switch($env){
  case dev:
  //error message
  $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
  .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
  return $errorMsg;
  break;
  case app:
  
  break;
    }
  }
 }
