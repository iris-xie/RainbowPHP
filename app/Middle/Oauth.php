<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/6/2
 * Time: 1:11
 */
namespace App\Middle;

class Oauth
{


    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    function checkOauth()
    {
        echo '授权中间件加载完成<br/>';
        return true;
    }
}