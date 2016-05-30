<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/28
 * Time: 12:41
 */
namespace RainbowPHP\Helpers;
use App\Config\Config_middleware;
class RainbowHelpers
{
    public static function runRoute($callbacks,$paramter=[],$isController=false)
    {

        if (!is_object($callbacks)) {

            // Grab all parts based on a / separator
            $parts = explode('/',$callbacks);

            // Collect the last index of the array
            $last = end($parts);

            // Grab the controller name and method call
            $segments = explode('@',$last);

            // Instanitate controller
            $controller = new $segments[0]();

            // Call method
            if(!method_exists($controller, $segments[1])) {

                echo "类 and 方法 不匹配";
            }elseif(!$paramter){

                if($isController) self::beforeControllerMiddleware($segments[0]);

                $controller->{$segments[1]}();
                
                if($isController) self::afterControllerMiddleware($segments[0]);

            }else{

                if($isController) self::beforeControllerMiddleware($segments[0]);

                call_user_func_array(array($controller, $segments[1]), $paramter);
                
                if($isController) self::afterControllerMiddleware($segments[0]);

            }
        } else {
            // Call closure
            if(!$paramter){

                call_user_func($callbacks);
            }else{

                call_user_func_array($callbacks, $paramter);
            }

        }

    }


    public static function beforeControllerMiddleware($controller)
    {
        $middlewares = Config_middleware::$beforeController[$controller];

        foreach($middlewares as $val){

            self::runRoute($val);
        }

    }

    public static function afterControllerMiddleware($controller)
    {
        $middlewares = Config_middleware::$afterController[$controller];

        foreach($middlewares as $val){

            self::runRoute($val);
        }

    }

}
