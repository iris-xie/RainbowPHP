<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/18
 * Time: 23:59
 */
use RainbowPHP\Core\Router;
//use App\Controller\NewController;

/*Macaw::get('/fuck', function() {
    echo "成功！";
    $app = new NewController();
    return $app->index();S
});*/
Router::get('/fuck', 'App\Http\Controllers\NewController@index');

Router::get('/w/(:all)', function($fu) {
    echo '未匹配到路由<br>'.$fu;
});

