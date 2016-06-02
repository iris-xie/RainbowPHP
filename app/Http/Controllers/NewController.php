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
class NewController extends RainbowController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        echo '<br/>s21312s<br/>';

        //echo time().microtime();


        $this->loadDatabase();

        $log = Log::getInstance();

        $log ->add('-----'.time());
        //echo time().microtime();
        $this->loadView();
        echo $this->view->render('test.html.twig', array('the' => 'variables', 'go' => 'here'));
        //echo time().microtime();

    }

}