<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/11
 * Time: 21:29
 */
namespace App\Config;
class Config_sys
{
    public static $is_load   = [];
    public static $base_path = '/home/vagrant/web';
    public static $charset  = 'utf-8';
    public static $database = [
                            'driver' => 'mysql',
                            'host' => 'localhost',
                            'database' => 'rainbow',
                            'username' => 'root',
                            'password' => 'root',
                            'charset' => 'utf8',
                            'collation' => 'utf8_general_ci',
                            'prefix' => ''
                            ];

    public static $auto_load   = ['view', 'database', 'session', 'redis'];
    public static $env         = 'dev';
    public static $safety      = 'on';
    public static $log         = [
                            'log_type' => 'file',
                            'log_suffix' => '.log',
                            'log_default' => 'RainbowPHP',
                            'log_con' => 'single',
                            'file_path' => '/storage/logs'

    ];

/*    public function __callStatic($name, $arguments)
    {
        if($name == 'base_path') return dirname(dirname(__FILE__));
    }*/


}
