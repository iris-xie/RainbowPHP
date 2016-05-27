<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/24
 * Time: 22:09
 */
namespace App\Controller;
use RainbowPHP\Core\RainbowController;
use App\Models\PeopleModel;
class NewController extends RainbowController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        echo 's21312s';

        $INF0= PeopleModel::getOne(1);
        var_dump($INF0);

        echo $this->twig->render('test.html.twig', array('the' => 'variables', 'go' => 'here'));
    }
}