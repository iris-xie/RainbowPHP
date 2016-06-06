<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/4/29
 * Time: 下午2:39
 */
 
 //if(!extension_loaded('YAC')) exit('本框架严重依赖YAC扩展,请先安装YAC扩展');

require __DIR__ . '/../vendor/autoload.php';

$app = new \RainbowPHP\Core\Application(dirname(dirname(__FILE__)));

\Symfony\Component\HttpFoundation\Request::createFromGlobals();

//var_dump($_GET);
$app->beforeSysMiddleWare();

//需要进行处理参数
// 路由配置
require __DIR__ .'/../app/Config/Routes.php';
//分发路由 进入系统逻辑
\RainbowPHP\Core\Router::dispatch();

$app->afterSysMiddleWare();

$app->terminate();

