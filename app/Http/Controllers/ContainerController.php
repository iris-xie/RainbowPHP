<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/6/2
 * Time: 22:06
 */
namespace App\Http\Controllers;
use RainbowPHP\Core\RainbowController;
use App\Http\Models\PeopleModel;
use RainbowPHP\Core\Log;
class ContainerController extends RainbowController
{

    public function __construct()
    {
        parent::__construct();
    }


    public function testContainer(){


       $this->container->get('test')->index();
        //$INF0= PeopleModel::getOne(1);
        echo '<br/>获取数据<br/>';
    }
}