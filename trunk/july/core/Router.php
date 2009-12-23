<?php
class Router {
    private $preloadRoute;
    private $defaultRoute;
    public function __construct() {
        $_POST = $this->input($_POST);
        $_GET = $this->input($_GET);
        $_COOKIE = $this->input($_COOKIE);
    }
    public function setPreloadRoute($preloadArray) {
        if (!is_array($preloadArray)) {
            throw new Exception("the preload is not an Array\n");
        }elseif (empty($preloadArray['controler']) || empty($preloadArray['method'])) {
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
    public function setDefaultRoute($defaultArray) {
        $this->defaultRoute = $defaultArray;
    }
    public function route() {
        return $this->defaultRoute;
    }
    public function parse() {
        if (!empty($_GET['c'])) {
            $this->defaultRoute['controler'] = $_GET['c'];
            unset($_GET['c']);
        }
        if (!empty($_GET['m'])) {
            $this->defaultRoute['method'] = $_GET['m'];
            unset($_GET['m']);
        }
    }
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

