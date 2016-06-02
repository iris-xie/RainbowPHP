<?php
namespace App\Config;

use RainbowPHP\Core\Route;
class ConfigEventlistener
{

public static $eventList = [
              'beforeSystem' => ['App\Middle\Oauth@checkOauth'],
              'afterSystem' => ['App\Middle\Oauth@closeOauth'],
              'beforeRespone' => [],
              'afterRespone' => [],
];

public static function fire ($event)
{
  if(array_key_exist(self::$eventList,$event)){
    
    foreach(self::$eventList[$event] as $val){
        Route::runRoute($val);
    }
  }else {

  throw EventNotFoundException($event);
  }
}









}
