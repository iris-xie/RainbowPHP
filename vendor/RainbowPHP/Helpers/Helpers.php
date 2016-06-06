<?php
/**
 * Created by PhpStorm.
 * User: risky
 * Date: 16/4/29
 * Time: 下午3:09
 */
use RainbowPHP\Support\Str;
 function load_class($class)  
    {  
        //记录加载过的类  
        static $load_classes = array();  
  
        // 已经加载过，直接读取并返回  
        if (isset($load_classes[$class]))  
        {  
            return $load_classes[$class];  
        }  
  
        $name = FALSE;  

        $yac = new Yac("rainbow_");
        
        if($content = $yac->get(md5($class))){
            
            eval($content);
    
        }else{
            
            $path = explode('\',$class);
            
            if(empty($path[0])) array_shift($path);
            
            $realpath = BASEPATH.'/vendor/'.strtoupper(join('/',$path)).'.php';
            
            if(!file_exists($realpth)){
                
                 exit('Unable to locate the specified path: '.$realpath.'.php'); 
            }
            
            $content = file_get_contents($realpath);
        
            $yac->set(md5($class),$content);
            
            include $realpath;
            
        }
 
        // 追踪记录下刚才加载的类，is_loaded()函数在下面  
        is_loaded($class);  
  
        $loaded_classes[$class] = new $class();  
        return $_classes[$class];  
    } 

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
                return true;

            case 'false':
                return false;

            case 'empty':
                return '';

            case 'null':
                return null;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

function RainbowError($errno, $errstr, $errfile, $errline)
{
    echo "<b>Custom error:</b> [$errno] $errstr<br />";
    echo " Error on line $errline in $errfile<br />";
    echo "Ending Script";
}

function RainbowException($exception) {
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
}
function RainbowShutdown() {
    echo "shutdown\n";
}
