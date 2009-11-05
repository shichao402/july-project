<?php
class AutoLoad {
    public static function __autoload() {
        
    }
    public static function BookMark($class) {
        $filePath = './class/'.$class.'.php';
        if (self::checkFile($filePath)) {
            require_once($filePath);
        }
    }
    private static function checkFile($filePath) {
        return is_file($filePath);
    }
}
?>
