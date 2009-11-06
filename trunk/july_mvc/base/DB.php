<?php
class DB {
    static private $connection = null;
    static private $engine = null;
    static public function handle() {
        if (self::$connection === null) {
            throw new Exception('no db conncection', 001);
        }else {
            return self::$connection;
        }
    }
    static public function createConnection($host = 'localhost',$user = 'root',$pass = '',$dbname = null) {
        require_once('DBDriver/'.self::$engine.'.php');
        self::$connection = new self::$engine($host,$user,$pass,$dbname);
    }
    static public function setEngine($engineName) {
        self::$engine = $engineName;
    }
}
?>
