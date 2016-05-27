<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/11
 * Time: 21:29
 */
$config =[
    'ENVIRONMENT'=>'dev',
    'safety'=>'on',
];
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
return $config;