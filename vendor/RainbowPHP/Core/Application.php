<?php
/**
 * Created by PhpStorm.
 * User: risky
 * Date: 16/4/29
 * Time: 下午2:52
 */
namespace RainbowPHP\Core;
use App\Config\Config_middleware;
use App\Config\Config_sys;
use RainbowPHP\Helpers\RainbowHelpers;
use RainbowPHP\Core\Log;
class Application
{
    /**
     * The RainbowPHP framework version.
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * The base path for the RainbowPHP installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Indicates if the application has "booted".
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * The array of booting callbacks.
     *
     * @var array
     */
    protected $beforeBootedMiddlewares = [];

    /**
     * The array of booted callbacks.
     *
     * @var array
     */
    protected $afterBootedMiddlewares  = [];

    /**
     * The array of terminating callbacks.
     *
     * @var array
     */
    protected $terminatingMiddlewares = [];

    /**
     * A custom callback used to configure Log.
     *
     * @var callable|null
     */
    protected $LogConfig;

    /**
     * The custom database path defined by the developer.
     *
     * @var string
     */
    protected $databasePath;

    /**
     * The custom storage path defined by the developer.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * The custom environment path defined by the developer.
     *
     * @var string
     */
    protected $environmentPath;

    /**
     * The environment file to load during bootstrapping.
     *
     * @var string
     */
    protected $environmentFile = 'config.php';

    /**
     * The application namespace.
     *
     * @var string
     */
    protected $namespace = null;
    /**
     * The application namespace.
     *
     * @var string
     */
    protected $middleware = null;
    
    /**
     * The application namespace.
     *
     * @var string
     */
    protected $env = null;
    protected $safety = null;

    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
        
        $this -> run();
        
    }
    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function run()
    {
        if ($this->booted) {
            return;
        }
        //echo time().microtime();
        $this->booted = true;

        $this->setEnv();
        
        $this->setSafetyMod();
        
        $this->setCharset();
        
        $this->setHandler();
        
        //$this->LogConfig = Config_sys::log;
        //初始化log类
        Log::getInstance();
       
    }
    protected function setEnv(){
        
        $this -> env = Config_sys::$env;
        
        switch ( $this -> env ) {
            case 'dev' :
                error_reporting(7);
                break;

            case 'testing' :
                break;
            case 'production' :
                error_reporting(0);
                break;

            default :
                throw WrongConfigException('The application environment is not set correctly.');
        }
    } 
    protected function setEnv(){
    
        return $this -> env;
    }
    
    protected function setSafetyMod()
    {
                //echo time().microtime();
        $this -> safety = Config_sys::$safety;

        if($this -> safety){
            ini_set('magic_quotes_runtime', 1);
        }else{
            ini_set('magic_quotes_runtime', 0);
        }
    }
    protected function setCharset()
    {
                //echo time().microtime();
        $this -> charset = Config_sys::$charset;

        ini_set('default_charset',  $this -> charset);
        if (extension_loaded('mbstring'))
        {
            if(!defined('MB_ENABLED'))define('MB_ENABLED', TRUE);
            // mbstring.internal_encoding is deprecated starting with PHP 5.6
            // and it's usage triggers E_DEPRECATED messages.
            @ini_set('mbstring.internal_encoding', $this -> charset);
            // This is required for mb_convert_encoding() to strip invalid characters.
            // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
            mb_substitute_character('none');
        }
        else
        {
            if(!defined('MB_ENABLED'))define('MB_ENABLED', FALSE);
        }

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
        if (extension_loaded('iconv'))
        {
            if(!defined('ICONV_ENABLED'))define('ICONV_ENABLED', TRUE);
            // iconv.internal_encoding is deprecated starting with PHP 5.6
            // and it's usage triggers E_DEPRECATED messages.
            @ini_set('iconv.internal_encoding',  $this -> charset);
        }
        else
        {
            if(!defined('ICONV_ENABLED'))define('ICONV_ENABLED', FALSE);
        }

        if (is_php('5.6'))
        {
            ini_set('php.internal_encoding',  $this -> charset);
        }

    }
    
    
    public function setHandler(){

        set_error_handler('RainbowError');

        set_exception_handler('RainbowException');

        register_shutdown_function('RainbowShutdown');
    }

    public function beforeSysMiddleWare(){

        $this->beforeSysMiddleWare=Config_middleware::$beforeSys;

        foreach(Config_middleware::$beforeSys as $val){

            RainbowHelpers::runRoute($val);

        }

        echo '系统前中间件加载完成<br/>';
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        return $this;
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app';
    }

    /**
     * Get the base path of the RainbowPHP installation.
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config';
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath()
    {
        return $this->environmentPath ?: $this->basePath;
    }

    /**
     * Set the directory for the environment file.
     *
     * @param  string  $path
     * @return $this
     */
    public function useEnvironmentPath($path)
    {
        $this->environmentPath = $path;

        return $this;
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param  string  $file
     * @return $this
     */
    public function loadEnvironmentFrom($file)
    {
        $this->environmentFile = $file;

        return $this;
    }

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath()
    {
        return $this->environmentPath().'/'.$this->environmentFile();
    }

    /**
     * Get or check the current application environment.
     *
     * @param  mixed
     * @return string|bool
     */
    public function environment()
    {
        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $this['env'])) {
                    return true;
                }
            }

            return false;
        }

        return $this['env'];
    }

    /**
     * Determine if application is in local environment.
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this['env'] == 'local';
    }

    /**
     * Determine if we are running unit tests.
     *
     * @return bool
     */
    public function runningUnitTests()
    {
        return $this['env'] == 'testing';
    }
    
    /**
     * Determine if the given abstract type has been bound.
     *
     * (Overriding Container::bound)
     *
     * @param  string  $abstract
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->deferredServices[$abstract]) || parent::bound($abstract);
    }

    /**
     * Determine if the application has booted.
     *
     * @return bool
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * Boot the given service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider  $provider
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }


    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached()
    {
        return false;
    }

    /**
     * Register a terminating callback with the application.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function terminating()
    {
        return $this;
    }

    /**
     * Terminate the application.
     *
     * @return void
     */
    public function terminate()
    {
     
    }

    /**
     * Define a callback to be used to configure Monolog.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function configureLogUsing(callable $callback)
    {
        $this->LogConfigurator = $callback;

        return $this;
    }

    /**
     * Determine if the application has a custom Monolog configurator.
     *
     * @return bool
     */
    public function hasLogConfigurator()
    {
        return ! is_null($this->LogConfigurator);
    }

    /**
     * Get the custom Monolog configurator for the application.
     *
     * @return callable
     */
    public function getLogConfigurator()
    {
        return $this->LogConfigurator;
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        $aliases = [
            'app'                  => ['Illuminate\Foundation\Application', 'Illuminate\Contracts\Container\Container', 'Illuminate\Contracts\Foundation\Application'],
            'auth'                 => ['Illuminate\Auth\AuthManager', 'Illuminate\Contracts\Auth\Factory'],
            'auth.driver'          => ['Illuminate\Contracts\Auth\Guard'],
            'blade.compiler'       => ['Illuminate\View\Compilers\BladeCompiler'],
            'cache'                => ['Illuminate\Cache\CacheManager', 'Illuminate\Contracts\Cache\Factory'],
            'cache.store'          => ['Illuminate\Cache\Repository', 'Illuminate\Contracts\Cache\Repository'],
            'config'               => ['Illuminate\Config\Repository', 'Illuminate\Contracts\Config\Repository'],
            'cookie'               => ['Illuminate\Cookie\CookieJar', 'Illuminate\Contracts\Cookie\Factory', 'Illuminate\Contracts\Cookie\QueueingFactory'],
            'encrypter'            => ['Illuminate\Encryption\Encrypter', 'Illuminate\Contracts\Encryption\Encrypter'],
            'db'                   => ['Illuminate\Database\DatabaseManager'],
            'db.connection'        => ['Illuminate\Database\Connection', 'Illuminate\Database\ConnectionInterface'],
            'events'               => ['Illuminate\Events\Dispatcher', 'Illuminate\Contracts\Events\Dispatcher'],
            'files'                => ['Illuminate\Filesystem\Filesystem'],
            'filesystem'           => ['Illuminate\Filesystem\FilesystemManager', 'Illuminate\Contracts\Filesystem\Factory'],
            'filesystem.disk'      => ['Illuminate\Contracts\Filesystem\Filesystem'],
            'filesystem.cloud'     => ['Illuminate\Contracts\Filesystem\Cloud'],
            'hash'                 => ['Illuminate\Contracts\Hashing\Hasher'],
            'translator'           => ['Illuminate\Translation\Translator', 'Symfony\Component\Translation\TranslatorInterface'],
            'log'                  => ['Illuminate\Log\Writer', 'Illuminate\Contracts\Logging\Log', 'Psr\Log\LoggerInterface'],
            'mailer'               => ['Illuminate\Mail\Mailer', 'Illuminate\Contracts\Mail\Mailer', 'Illuminate\Contracts\Mail\MailQueue'],
            'auth.password'        => ['Illuminate\Auth\Passwords\PasswordBrokerManager', 'Illuminate\Contracts\Auth\PasswordBrokerFactory'],
            'auth.password.broker' => ['Illuminate\Auth\Passwords\PasswordBroker', 'Illuminate\Contracts\Auth\PasswordBroker'],
            'queue'                => ['Illuminate\Queue\QueueManager', 'Illuminate\Contracts\Queue\Factory', 'Illuminate\Contracts\Queue\Monitor'],
            'queue.connection'     => ['Illuminate\Contracts\Queue\Queue'],
            'queue.failer'         => ['Illuminate\Queue\Failed\FailedJobProviderInterface'],
            'redirect'             => ['Illuminate\Routing\Redirector'],
            'redis'                => ['Illuminate\Redis\Database', 'Illuminate\Contracts\Redis\Database'],
            'request'              => ['Illuminate\Http\Request', 'Symfony\Component\HttpFoundation\Request'],
            'router'               => ['Illuminate\Routing\Router', 'Illuminate\Contracts\Routing\Registrar'],
            'session'              => ['Illuminate\Session\SessionManager'],
            'session.store'        => ['Illuminate\Session\Store', 'Symfony\Component\HttpFoundation\Session\SessionInterface'],
            'url'                  => ['Illuminate\Routing\UrlGenerator', 'Illuminate\Contracts\Routing\UrlGenerator'],
            'validator'            => ['Illuminate\Validation\Factory', 'Illuminate\Contracts\Validation\Factory'],
            'view'                 => ['Illuminate\View\Factory', 'Illuminate\Contracts\View\Factory'],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path().'/'.$pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }
}
