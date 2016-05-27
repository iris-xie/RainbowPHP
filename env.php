<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/11
 * Time: 21:29
 */


$config['database'] = [

    'driver'    => 'mysql',

    'host'      => 'localhost',

    'database'  => 'rainbow',

    'username'  => 'root',

    'password'  => 'root',

    'charset'   => 'utf8',

    'collation' => 'utf8_general_ci',

    'prefix'    => ''

];

$config['auto_load'] = ['view','database','session','redis'];
$config['ENVIRONMENT'] = 'dev';
$config['safety'] = 'on';
return $config;

