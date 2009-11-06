<?php
class Router {
    static public $controler;
    static public $method;
    static public $param;
    static public function parse() {
        if (isset($_SERVER['PATH_INFO'])){
           $parseResult = explode('/', substr($_SERVER['PATH_INFO'].' ', 1, -1));
           self::$controler = !empty($parseResult[0]) ? $parseResult[0] : 'index';
           self::$method = isset($parseResult[1]) ? $parseResult[1] : 'index';
           unset($parseResult[0]);
           unset($parseResult[1]);
           foreach ($parseResult as $param) {
               self::$param[] = $param;
           }
       }else {
           self::$controler = 'index';
           self::$method = 'index';
       }
//       var_dump(self::$controler,self::$method,self::$param);
    }
    static public function start() {
        $controler = new self::$controler;
        $method = self::$method;
        $controler->{$method}();
    }
}
?>

