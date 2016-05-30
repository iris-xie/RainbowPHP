<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/4/29
 * Time: 下午2:39
 */

require __DIR__ . '/../vendor/autoload.php';
//echo time().microtime();//define(BASE_PATH,dirname(dirname(__FILE__)));

//echo BASE_PATH;

$app = new \RainbowPHP\Core\Application(dirname(dirname(__FILE__)));

$app->beforeSysMiddleWare();

//需要进行处理参数
// 路由配置
require __DIR__ .'/../app/Config/routes.php';


$app->afterSysMiddleWare();

$app->terminate();

/*
|--------------------------------------------------------------------------
| 处理请求
|--------------------------------------------------------------------------
|
*/
/*$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);*/

/*
|--------------------------------------------------------------------------
| 发送响应
|--------------------------------------------------------------------------
|
*/

/*$response->send();*/

/*
|--------------------------------------------------------------------------
| 终止本次回话
|--------------------------------------------------------------------------
|
*/

/*$kernel->terminate($request, $response);*/

