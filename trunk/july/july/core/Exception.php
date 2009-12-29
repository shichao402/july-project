<?php
class FileSystemException extends Exception {
    
}
class DBException extends Exception {
    
}
class UserException extends Exception {
    private $type;
    public function __construct($message,$type,$code = null) {
        parent::__construct($message, $code);
        $this->type = $type;
    }
    public function getType() {
        return $this->type;
    }
}
?>