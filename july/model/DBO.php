<?php
class DBO {
    public function __construct($table) {

    }
    public function insert() {
        $queryString = "
        INSERT INTO $table
        (`".implode('`,`',$fieldKeys)."`)
        VALUES ('".implode("','",$fieldValues)."')
        ";
    }
    public function update() {
        //$table $fieldKeys $fieldValues
        //where [$field = $value[..]]
    }
    public function select() {
        
    }
}
array('insert' =>
        array(
            $array = array($key => $value)
        )
);
?>
