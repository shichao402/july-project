<?php
abstract class Controller {
    /**
     * views file name
     * @var array 
     */
    protected $view = array();
    /**
     *  the data that models render
     * @var array
     */
    protected $data = array();
    /**
     * the views file path
     * @var string
     */
    protected $viewsPath = './views';
    /**
     *  render the $array which wants to view,$array must have associate key.
     * @param array $array the data that wants to view
     */
    public function render($array) {
        if (is_array($array)) {
            foreach ($array as $key => $data) {
                $this->data[$key] = $data;
            }
        }else {
            throw new Exception("render data must be an array\n");
        }
    }
    /**
     * extract the data to the view files,and show it.
     */
    public function view() {
        extract($this->data);
        foreach ($this->view as $__view) {
            include($__view);
        }
    }
    /**
     *  load views file path by views name.
     * @param string $viewName vies name
     */
    public function loadView($viewName) {
        if (file_exists($this->viewsPath.'/'.$viewName.'.php')) {
            $this->view[$viewName] = $this->viewsPath.'/'.$viewName.'.php';
        }else {
            throw new Exception("can not find views file.\n");
        }
    }
}

?>
