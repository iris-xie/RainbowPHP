<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/18
 * Time: 23:59
 */
use NoahBuscher\Macaw\Macaw;
//use App\Controller\NewController;

/*Macaw::get('/fuck', function() {
    echo "成功！";
    $app = new NewController();
    return $app->index();
});*/
Macaw::get('/fuck', 'App\Controller\NewController@index');

Macaw::get('/wqeq/(:all)', function($fu) {
    echo '未匹配到路由<br>'.$fu;
});

Macaw::dispatch();