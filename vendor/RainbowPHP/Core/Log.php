<?php
namespace RainbowPHP\Core;
use App\Config\Config_sys;
class Log
{
    
   //日志记录内存变量
   private static $logs = [];
   
   //日志文件类型（默认file）
   private static $log_type = 'file';

   private static $_instance;
   
   //logrotate   single
   private static $log_con = '';

   private static $base_path = '';

   //日志文件路径
   private static $log_paths = array();
   
   private function __construct()
   {
      self::$log_type = Config_sys::$log['log_type'];
      
      self::$log_con = Config_sys::$log['log_con'];

      self::$base_path = Config_sys::$base_path.Config_sys::$log['file_path'];

   }
   
    public static function getInstance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
   
   /**
    * 增加一条日志记录(并不会马上保存，由系统结束运行时调用 log::save 方法保存)
    * @param $log_name (日志文件名[英文数字或下划线组成])
    *        通常情况下，对应的实际文件名是 $log_path/$log_name.'log'
    *        如果要指定使用特定的层级目录，直接使用 $path1/$path2/$log_name 这样作为 $log_name 即可
    *
    * @parem $msg  日志信息
    * @return void
    */
    public function add($msg,$type='INFO',$log_name='')
    {
        if(empty($log_name)) $log_name = Config_sys::$log['log_default'];
        if(is_array($msg)){
            $new_msg = strtoupper($type).': '.join(',',$msg).'||'.date('Y-m-d H:i:s',time()).PHP_EOL;
            }else{
            $new_msg = strtoupper($type).': '.$msg.'||'.date('Y-m-d H:i:s',time()).PHP_EOL;
        }
        self::$logs[$log_name][] = $new_msg;
    }
    
   /**
    * 保存日志(由php运行结束时自动调用)
    *
    * @return void
    */               
    public function save()
    {
        foreach(self::$logs as $log_name => $log_datas )
        {
            $log_file = self::get_log_path( $log_name );
            $msgs = '';
            foreach($log_datas as $msg) {
                $msgs .= $msg;
            }
            if ( ! $fp = @fopen($log_file, 'a'))
               {
                       return FALSE;
               }
               flock($fp, LOCK_EX);
               fwrite($fp, $msgs);
               flock($fp, LOCK_UN);
               fclose($fp);

               @chmod($log_file, 0766);
            //file_put_contents($log_file, $msgs, FILE_APPEND);
            self::$logs = [];
            self::$_instance = [];
        }
    }
    
   /**
    * 获得日志文件存放目录
    */
    private function get_log_path($path_name)
    {
        $base_path = self::$base_path;
        
        //path_name只能同英文数字和下划线、'/'组成，并且不能最前或最后带 / 
        $path_name = preg_replace('#[^\w/]#', '', $path_name);
        $path_name = preg_replace('#^/#', '', $path_name);
        $path_name = preg_replace('#/$#', '', $path_name);
        
        //看看有没有已经计算好的文件名
        if( isset(self::$log_paths[$path_name]) )
        {
            return self::$log_paths[$path_name];
        }
        
        //计算实际路径及文件名
        if( !preg_match('#/#', $path_name) )
        {
          if(self::$log_con == "single"){
          
              self::$log_paths[$path_name] = $base_path.'/'.$path_name.'.log';
          }elseif(self::$log_con == "logrorate"){
          
              self::$log_paths[$path_name] = $base_path.'/'.$path_name.'-'.date('Y-m-d',time()).'.log';
          }
            //self::$log_paths[$path_name] = $base_path.'/'.$path_name.'.log';
            return self::$log_paths[$path_name];
        }
        else
        {
            $log_name = preg_replace("#(.*)/#", '', $path_name);
            $path = preg_replace("#/{$log_name}$#", '', $path_name);
            $paths = explode('/', $path);
            foreach($paths as $p)
            {
                if( $p != '' )
                {
                    $base_path .= '/'.$p;
                    if( !is_dir($base_path) ) {
                        mkdir($base_path, 0660);
                    }
                }
            }
          if(self::$log_con == "single"){
          
              self::$log_paths[$path] = $base_path.'/'.$log_name.'.log';
          }elseif(self::$log_con == "logrorate"){
          
              self::$log_paths[$path] = $base_path.'/'.$log_name.'-'.date('Y-m-d',time()).'.log';
          }
            
            return self::$log_paths[$path];
        }
    }
    
}
