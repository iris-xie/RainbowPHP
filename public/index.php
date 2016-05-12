<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/4/29
 * Time: 下午2:39
 */
$config = include __DIR__.'/../env.php';

//var_dump($config);

/*function classLoader($class_name) {
    echo 'SPL load class:', $class_name, '<br />';
}
set_include_path(realpath(__DIR__.'/../vendor/RainbowPHP'). "/Core/");


spl_autoload_register();

echo get_include_path();*/
//echo env('APP_KEY');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (in_array('ENVIRONMENT',$config)) {
    switch ($config['ENVIRONMENT']) {
        case 'development' :
            error_reporting(7);
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
include __DIR__.'/../vendor/RainbowPHP/Helpers/Common.php';

include __DIR__.'/../vendor/RainbowPHP/Core/application.class.php';
$app = new \RainbowPHP\Core\Application(realpath(__DIR__.'/../'));

var_dump($app);

/*
|--------------------------------------------------------------------------
| 检查中间件
|--------------------------------------------------------------------------
|
*/
set_error_handler('_error_handler');
set_exception_handler('_exception_handler');
register_shutdown_function('_shutdown_handler');
$kernel = $app->beforeMiddleWare();

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

