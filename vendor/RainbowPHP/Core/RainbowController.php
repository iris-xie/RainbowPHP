<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/26
 * Time: 0:15
 */
namespace RainbowPHP\Core;
use Illuminate\Database\Capsule\Manager;
use App\Config\Config_sys;
class RainbowController{

    protected $twig;

    protected $database;
    public static $instance;

    public function __construct()
    {
        //$config = include BASE_PATH.'/env.php';
        if (isset(Config_sys::$is_load[__CLASS__]))
        {
                    return Config_sys::$is_load[__CLASS__];
        }
        //echo time().microtime();

        if(in_array('view',Config_sys::$auto_load)){

            $this->loadView();

        }
        if(in_array('database',Config_sys::$auto_load)) {
            $this->loadDatabase();

        }

        self::$instance =& $this;

        Config_sys::$is_load[__CLASS__] = &$this;
    }
/*    public function __callstatic($name,$arguments)
    {
     return call_user_func_array(__CLASS__,$name,$arguments);  
    }*/
    
     //这个函数对外提供了控制器的单一实例  
    public  function &get_instance()
    {  
        return self::$instance;  
    }

    public function load ($name)
    {

        if(!in_array('view',Config_sys::$auto_load)){

            $this->loadView();
        }
        if(!in_array('database',Config_sys::$auto_load)) {

            $this->loadDatabase();
        }

    }

    protected function loadView(){

        $loader = new \Twig_Loader_Filesystem(Config_sys::$base_path.'/app/Http/views/');
        $twig = new \Twig_Environment($loader, []);
        $this->view=$twig;

    }

    protected function loadDatabase()
    {
        $capsule = new Manager;

        $capsule->addConnection(Config_sys::$database);
        $capsule->bootEloquent();

        $this->database = $capsule;

    }
}
