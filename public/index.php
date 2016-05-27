<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/4/29
 * Time: 下午2:39
 */
$config = include __DIR__.'/../env.php';
global $config;
define(BASE_PATH,dirname(dirname(__FILE__)));

echo BASE_PATH;

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


    switch ($config['ENVIRONMENT']) {
        case 'dev' :
            error_reporting(7);
            break;

        case 'testing' :
        case 'production' :
            error_reporting(0);
            break;

        default :
            exit('The application environment is not set correctly.');
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
//include __DIR__.'/../vendor/RainbowPHP/Helpers/Common.php';

//include __DIR__.'/../vendor/RainbowPHP/Core/application.class.php';
require __DIR__ . '/../vendor/autoload.php';

$app = new RainbowPHP\Core\Application(realpath(__DIR__.'/../'));

/*
|--------------------------------------------------------------------------
| 检查中间件
|--------------------------------------------------------------------------
|
*/
if($config['safety']=='on'){
    ini_set('magic_quotes_runtime', 1);
}else{
    ini_set('magic_quotes_runtime', 0);
}


$charset = $config['charset'];
ini_set('default_charset', $charset);

if (extension_loaded('mbstring'))
{
    define('MB_ENABLED', TRUE);
    // mbstring.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('mbstring.internal_encoding', $charset);
    // This is required for mb_convert_encoding() to strip invalid characters.
    // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
    mb_substitute_character('none');
}
else
{
    define('MB_ENABLED', FALSE);
}

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
if (extension_loaded('iconv'))
{
    define('ICONV_ENABLED', TRUE);
    // iconv.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('iconv.internal_encoding', $charset);
}
else
{
    define('ICONV_ENABLED', FALSE);
}

if (is_php('5.6'))
{
    ini_set('php.internal_encoding', $charset);
}

set_error_handler('RainbowError');

set_exception_handler('RainbowException');

register_shutdown_function('RainbowShutdown');

$kernel = $app->beforeMiddleWare();

echo '122'."\n";
// 路由配置
require '../config/routes.php';
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

