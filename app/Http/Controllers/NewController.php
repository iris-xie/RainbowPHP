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
use RainbowPHP\Core\Log;
class NewController extends RainbowController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        echo '<br/>s21312s<br/>';

        //echo time().microtime();

        $INF0= PeopleModel::getOne(1);
        echo '<br/>获取数据<br/>';
        $log = Log::getInstance();

        $log ->add('-----'.time());
        //echo time().microtime();

        echo $this->view->render('test.html.twig', array('the' => 'variables', 'go' => 'here'));
        //echo time().microtime();

    }
}