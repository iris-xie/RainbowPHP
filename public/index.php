<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/4/29
 * Time: 下午2:39
 */

define('ENVIRONMENT', 'development');
function classLoader($class_name) {
    echo 'SPL load class:', $class_name, '<br />';
}
set_include_path(realpath(__DIR__.'/../vendor/RainbowPHP'). "/Core/");


spl_autoload_register();

echo get_include_path();
//echo env('APP_KEY');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development' :
            error_reporting(E_ALL);
            break;

        case 'testing' :
        case 'production' :
            error_reporting(0);
            break;

        default :
            exit('The application environment is not set correctly.');
    }
}
/**
 * RainbowPHP - A PHP Framework cut from laravel
 * @package  RainbowPHP
 * @author   Rainbow <siqimochi0@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| 加载系统 启动项
|--------------------------------------------------------------------------
*/

$app = new application(realpath(__DIR__.'../'));

/*
|--------------------------------------------------------------------------
| 启动主程序
|--------------------------------------------------------------------------
|
*/

$kernel = $app->make();

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

