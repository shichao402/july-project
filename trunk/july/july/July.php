<?php
define('JULY_ROOT',dirname(__FILE__));
class July {
    public $autoload;
    public $router;
    static public $instance;
    /**
     *  create or get instance
     * @param string $name
     * @return July::Object
     */
    static public function instance($name = null) {
        if ($name === null) {
            if (self::$instance == null) {
                self::$instance = new July();
                return self::$instance;
            }else {
                return self::$instance;
            }
        } else {
            if (empty(self::$instance->{$name})) {
                throw new Exception("{$name} is not an instance\n");
            }else {
                return self::$instance->{$name};
            }
        }
    }
    public function __construct() {
        require_once(JULY_ROOT.'/core/Cache.php');
        require_once(JULY_ROOT.'/core/Viewer.php');
        require_once(JULY_ROOT.'/core/DataProvider.php');
        require_once(JULY_ROOT.'/core/Autoload.php');
        require_once(JULY_ROOT.'/core/Router.php');
        require_once(JULY_ROOT.'/core/Controler.php');
        require_once JULY_ROOT.'/core/Exception.php';
        $this->autoload = new Autoload();
        $this->router = new Router();
    }
    /**
     * parse route ,load and execute controler
     */
    public function run() {
        $this->router->parse();
        $route = $this->router->route();
        if (isset($route['controler']) && isset($route['method'])) {
            $c = new $route['controler']();
            $c->$route['method']();
        }else {
            throw new Exception("route is not effective\n");
        }
        }
}
?>
