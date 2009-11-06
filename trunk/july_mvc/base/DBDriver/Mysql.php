<?php
class Mysql {

    private $err_report = true;

    private $conn;

    private $queryCount;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->connect($dbHost, $dbUser, $dbPass, $dbName);
    }

    public function connect($dbHost, $dbUser, $dbPass, $dbName) {

        $this->conn = mysql_connect($dbHost, $dbUser, $dbPass) or exit($this->error());

        mysql_select_db($dbName, $this->conn) or exit($this->error());

        return $this->conn;

    }

    public function close() {

        return mysql_close($this->conn);

    }

    public function queryOne($queryString) {

        $resource = mysql_query($queryString,$this->conn) or $this->error($queryString);

        if ($resource) {

            $this->queryCount++;

            $result = mysql_fetch_array($resource) or $this->error();

        }

        return $result;

    }

    public function queryAsArray($queryString, $type = MYSQL_ASSOC) {

        $array = array();

        $resource = mysql_query($queryString,$this->conn) or $this->error($queryString);

        if ($resource) {

            $this->queryCount++;

            $temp = mysql_fetch_array($resource,$type);

            while($temp) {

                $array[] = $temp;

                $temp = mysql_fetch_array($resource,$type);

            }

            return $array;

        } else {

            return false;

        }

    }



    public function query($queryString) {

        $resource = mysql_query($queryString,$this->conn) or exit($this->error($queryString));

        $this->queryCount++;

        return $resource;

    }

    public function fetchArray($resource, $type = MYSQL_ASSOC) {//MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH

        $result = mysql_fetch_array($resource,$type);

        return $result;

    }

    public function rowsNum($resource) {

        $result = mysql_num_rows($resource);

        return $result;

    }

    public function fieldsNum($resource) {

        $result = mysql_num_fields($resource);

        return $result;

    }

    public function insertId() {

        $result = mysql_insert_id($this->conn);

        return $result;

    }

    public  function affectedRows() {

        $result = mysql_affected_rows($this->conn);

        return $result;

    }

    public function version() {

        $result = mysql_get_server_info($this->conn);

        return $result;

    }

    public function error($query = null) {

        if ($this->err_report == true) {

            if ($query != null) {

                echo "<pre>SQL: ".$query."]</pre>\n";

            }

            echo "<pre>Error: [".mysql_errno()."]".mysql_error()."</pre>\n";

        }

    }
//    public function setOrder($order,$sort = 'ASC') {
//        if (empty ($order)) {
//            $this->order =  '';
//        }else {
//            $this->order = ' ORDER BY '.$order.' '.$sort;
//        }
//    }
//    public function setLimit($limit) {
//        if (empty ($order)) {
//            $this->limit =  '';
//        }else {
//            $this->limit = ' LIMIT ('.$order.')';
//        }
//    }
//    public function setCoverage($coverage) {
//        if (!empty ($coverage)) {
//            $this->coverage .= ' AND '.$coverage;
//        }elseif (empty ($this->coverage)) {
//            $this->coverage .= ' '.$coverage;
//        }
//    }
}
?>
