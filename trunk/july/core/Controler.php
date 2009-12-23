<?php
abstract class Controller {
    protected $view;
    protected $data = array();
    protected $viewsPath = './views';
    public function render($array) {
        if (is_array($array)) {
            foreach ($array as $key => $data) {
                $this->data[$key] = $data;
            }
        }else {
            throw new Exception("render data must be an array\n");
        }
    }
    public function view() {
        extract($this->data);
        foreach ($this->view as $__view) {
            include($__view);
        }
    }
    public function loadView($viewName) {
        if (file_exists($this->viewsPath.'/'.$viewName.'.php')) {
            $this->view[$viewName] = $this->viewsPath.'/'.$viewName.'.php';
        }else {
            throw new Exception("can not find views file.\n");
        }
    }
}

?>
