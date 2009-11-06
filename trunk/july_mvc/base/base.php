<?php
abstract class Model {
    static public $handle;
    static public function init() {
        self::$handle = new Model();
    }
    static public function handle() {
        return self::$handle;
    }
    protected $DB;
    public function __construct() {
        $this->DB = DB::handle();
    }
}
class View {
    static public $handle;
    static public function init() {
        self::$handle = new View();
    }
    static public function handle() {
        return self::$handle;
    }
    private $data = array();
    private $view = array();

    public function loadView($viewName) {
        if (file_exists('views/'.$viewName.'.php')) {
            $this->view[$viewName] = 'views/'.$viewName.'.php';
        }else {
            throw new Exception('no file', 0);
        }
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function view() {
        extract($this->data);
        foreach ($this->view as $__view) {
            include($__view);
        }
        unset($__view);
    }
    public function clear() {
        $this->data = array();
        $this->view = array();
    }
}
abstract class Controller {
    static public $handle;
    static public function init() {
        self::$handle = new Controller();
    }
    static public function handle() {
        return self::$handle;
    }

    protected $data = array();
    public function render() {
        View::$handle->setData($this->data);
    }
    public function loadView($viewName) {
        View::$handle->loadView($viewName);
    }
    public function view() {
        View::$handle->view();
    }
}

?>
