 function &load_class($class, $directory = 'libraries', $prefix = 'CI_')  
    {  
        //记录加载过的类  
        static $_classes = array();  
  
        // 已经加载过，直接读取并返回  
        if (isset($_classes[$class]))  
        {  
            return $_classes[$class];  
        }  
  
        $name = FALSE;  
  
        // 在指定目录寻找要加载的类  
        foreach (array(APPPATH, BASEPATH) as $path)  
        {  
            if (file_exists($path.$directory.'/'.$class.'.php'))  
            {  
                $name = $prefix.$class;  
  
                if (class_exists($name) === FALSE)  
                {  
                    require($path.$directory.'/'.$class.'.php');  
                }  
  
                break;  
            }  
        }  
  
        // 没有找到  
        if ($name === FALSE)  
        {  
            exit('Unable to locate the specified class: '.$class.'.php');  
        }  
  
        // 追踪记录下刚才加载的类，is_loaded()函数在下面  
        is_loaded($class);  
  
        $_classes[$class] = new $name();  
        return $_classes[$class];  
    }  
    // 记录已经加载过的类。函数返回所有加载过的类  
    function &is_loaded($class = '')  
    {  
        static $_is_loaded = array();  
  
        if ($class != '')  
        {  
            $_is_loaded[strtolower($class)] = $class;  
        }  
  
        return $_is_loaded;  
    }  
  
//*BASEPATH/system/core/Controller.php  
class CI_Controller {  
  
    private static $instance;  
  
    public function __construct()  
    {  
        self::$instance =& $this;  
          
        //将所有在引导文件中(CodeIgniter.php)初始化的类对象(即刚才4,5,6,7,8,9等步骤)，  
        //注册成为控制器类的成员变量，就使得这个控制器成为一个超级对象(super object)  
        foreach (is_loaded() as $var => $class)  
        {  
            $this->$var =& load_class($class);  
        }  
<span style="white-space:pre">        </span>//加载Loader对象，再利用Loader对象对程序内一系列资源进行加载<span style="white-space:pre">  </span>  
        $this->load =& load_class('Loader', 'core');  
  
        $this->load->initialize();  
          
        log_message('debug', "Controller Class Initialized");  
    }  
  
    //这个函数对外提供了控制器的单一实例  
    public static function &get_instance()  
    {  
        return self::$instance;  
    }  
}  
  
  
//*BASEPATH/system/core/CodeIgniter.php  
    // Load the base controller class  
    require BASEPATH.'core/Controller.php';  
  
    //通过这个全局函数就得到了控制器的实例，得到了这个超级对象，  
    //意味着在程序其他地方调用这个函数，就能得到整个框架的控制权  
    function &get_instance()  
    {  
        return CI_Controller::get_instance();  
    }  
  
    // 加载对应的控制器类  
    // 注意：Router类会自动使用 router->_validate_request() 验证控制器路径  
    if ( ! file_exists(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php'))  
    {  
        show_error('Unable to load your default controller. Please make sure the controller specified in your Routes.php file is valid.');  
    }  
  
    include(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php');  
  
    $class  = $RTR->fetch_class(); //Controller class name  
    $method = $RTR->fetch_method(); //action name  
  
    //.....  
  
    // 调用请求的函数  
    // uri中除了class/function之外的段也会被传递给调用的函数  
    call_user_func_array(array(&$CI, $method), array_slice($URI->rsegments, 2));  
  
    //输出最终的内容到浏览器  
    if ($EXT->_call_hook('display_override') === FALSE)  
    {  
        $OUT->_display();  
    }  
      
  
//*BASEPATH/system/core/Loader.php  
    //看一个Loader类加载model的例子。这里只列出了部分代码  
    public function model($model, $name = '', $db_conn = FALSE)  
    {  
        $CI =& get_instance();  
        if (isset($CI->$name))  
        {  
            show_error('The model name you are loading is the name of a resource that is already being used: '.$name);  
        }  
  
        $model = strtolower($model);  
  
        //依次根据model类的path进行匹配，如果找到了就加载  
        foreach ($this->_ci_model_paths as $mod_path)  
        {  
            if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))  
            {  
                continue;  
            }  
  
            if ($db_conn !== FALSE AND ! class_exists('CI_DB'))  
            {  
                if ($db_conn === TRUE)  
                {  
                    $db_conn = '';  
                }  
  
                $CI->load->database($db_conn, FALSE, TRUE);  
            }  
  
            if ( ! class_exists('CI_Model'))  
            {  
                load_class('Model', 'core');  
            }  
  
            require_once($mod_path.'models/'.$path.$model.'.php');  
  
            $model = ucfirst($model);  
  
            //这里依然将model对象注册成控制器类的成员变量。Loader在加载其他资源的时候也会这么做  
            $CI->$name = new $model();  
  
            $this->_ci_models[] = $name;  
            return;  
        }  
  
        // couldn't find the model  
        show_error('Unable to locate the model you have specified: '.$model);  
    }  
  
//*BASEPATH/system/core/Model.php  
    //__get()是一个魔术方法，当读取一个未定义的变量的值时就会被调用  
    //如下是Model基类对__get()函数的一个实现，使得在Model类内，可以像直接在控制器类内一样(例如$this->var的方式)去读取它的变量  
    function __get($key)  
    {  
        $CI =& get_instance();  
        return $CI->$key;  
    }  
