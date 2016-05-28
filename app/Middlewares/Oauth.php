<?/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/12
 * Time: 0:08
 */
namespace App\MiddleWares;

class Oauth{


    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    function checkOauth()
    {
        echo '系统前中间件加载完成<br/>';
        return true;
    }
}