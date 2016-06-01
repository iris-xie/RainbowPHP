<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/12
 * Time: 0:06
 */
namespace App\Config;
class Config_middleware
{

//不支持闭包函数，
 public static $beforeSys = [

                'App\Middle\Oauth@checkOauth',

 ];


 public static $beforeController =[

                'App\Http\Controllers\NewController' => ['App\Middle\Oauth@continueOauth'],

 ];
 public static $afterController =[

               'App\Http\Controllers\NewController' => ['App\Middle\Oauth@afterOauth'],

 ];
 public static $afterSys = [

              'App\Middle\Oauth@closeOauth',

 ];

}