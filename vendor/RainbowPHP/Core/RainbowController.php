<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/26
 * Time: 0:15
 */
namespace RainbowPHP\Core;
use Illuminate\Database\Capsule\Manager;

class RainbowController{

<<<<<<< HEAD
    public $twig;

    protected $database;

    public function __construct()
    {
        $config = include BASE_PATH.'/env.php';

        //require_once BASE_PATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'twig'.DIRECTORY_SEPARATOR.'twig'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Twig'.DIRECTORY_SEPARATOR.'Autoloader.php';
        $loader = new \Twig_Loader_Filesystem(BASE_PATH.'/resources/views/');
        $twig = new \Twig_Environment($loader, array(
            //'cache' => BASE_PATH.'/cache/',
        ));
        $this->twig=$twig;

        $capsule = new Manager;

        $capsule->addConnection($config['database']);
        $capsule->bootEloquent();
        //var_dump($capsule);

        $this ->database = $capsule;

=======
    public $view;
    public $database;
    public static $instance;
    
    public function __construct()
    {
        self::$instance =& $this;  
        if(in_array('view',$config['auto_load'])){
        //require_once BASE_PATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'twig'.DIRECTORY_SEPARATOR.'twig'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Twig'.DIRECTORY_SEPARATOR.'Autoloader.php';
        $loader = new \Twig_Loader_Filesystem(BASE_PATH.'/resources/views/');
        $twig = new \Twig_Environment($loader, []));
        $this->view=$twig;
        }
>>>>>>> origin/master
    }
    
    public function __callstatic($name,$arguments)
    {
     return call_user_func_array(__CLASS__,$name,$arguments);  
    }
    
     //这个函数对外提供了控制器的单一实例  
    public static function &get_instance()  
    {  
        return self::$instance;  
    }  
}
