<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/24
 * Time: 22:09
 */
namespace App\Http\Controllers;
use RainbowPHP\Core\RainbowController;
use App\Http\Models\PeopleModel;
class NewController extends RainbowController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        echo 's21312s';

        //echo time().microtime();

        $INF0= PeopleModel::getOne(1);
        echo '获取数据';
        //echo time().microtime();

        echo $this->view->render('test.html.twig', array('the' => 'variables', 'go' => 'here'));
        //echo time().microtime();

    }
}