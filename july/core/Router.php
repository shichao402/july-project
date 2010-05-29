<?php
class Router {
    private $preloadRoute;
    private $route;
    /**
     * create an object to parse route and user input data
     */
    public function __construct() {
        $_POST = $this->input($_POST);
        $_GET = $this->input($_GET);
        $_COOKIE = $this->input($_COOKIE);
    }
    public function setPreloadRoute($preloadArray) {
        if (!is_array($preloadArray)) {
            throw new Exception("the preload is not an Array\n");
        }elseif (empty($preloadArray['controller']) || empty($preloadArray['method'])) {
            throw new Exception("the preload is not an effect Array");
        }else {
            $this->preloadRoute[] = $preloadArray;
        }
    }
    public function preloadRoute() {
        if (empty($this->preloadRoute)) {
            throw new Exception("nothing to preload\n");
        }
        else {
            return $this->preloadRoute;
        }
    }
    /**
     *  set default route.while controler or method is not defined,this will be usefull
     * @param array $defaultArray
     */
    public function setDefaultRoute($defaultArray) {
        if (isset($defaultArray['controller']) && isset($defaultArray['method'])) {
            $this->route = $defaultArray;
        }else {
            throw new Exception("default route array is not effective\n");
        }
    }
    /**
     *  get parsed route
     * @return <type> 
     */
    public function route() {
        return $this->route;
    }
    /**
     * parse url
     */
    public function parse() {
        if (!empty($_GET['c'])) {
            $this->route['controller'] = $_GET['c'];
            unset($_GET['c']);
        }
        if (!empty($_GET['m'])) {
            $this->route['method'] = $_GET['m'];
            unset($_GET['m']);
        }
    }
    /**
     *  user input filter
     * @param mixed $data
     * @return mixed
     */
    private function input($data) {
        array_walk_recursive($data,array($this,'slashes'));
        return $data;
    }
    private function slashes(& $value,$key) {
        if (get_magic_quotes_gpc() === 0) {
            $value = addslashes($value);
        }
        $value = trim($value);
    }
}
?>