<?php
class DB {
    private $host;
    private $user;
    private $pass;
    private $name;
    private $connection;
    private $queryCount;
    private $defaultResultType = MYSQL_ASSOC;
    private $affectRows;
    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->host = $dbHost;
        $this->user = $dbUser;
        $this->pass = $dbPass;
        $this->name = $dbName;
    }
    public function connect() {
        $this->connection = mysql_connect($this->host, $this->user, $this->pass);
        if ($this->connection === false) {
            $this->connection = null;
            throw new Exception("can not connect to mysql.\n");
        }
        else {
            if (!mysql_select_db($this->name, $this->connection)) {
                throw new Exception("can not use database {$dbName}.\n");
            }
            else {
                if ((float) substr(mysql_get_server_info($this->connection),0,3) > 4.1) {
                    $this->query("SET NAMES 'utf8'");
                }
            }
        }
    }
    public function useDB($dbName) {
        if (mysql_select_db($dbName, $this->connection)) {
            $this->name = $dbName;
            if ((float) substr(mysql_get_server_info($this->connection),0,3) > 4.1) {
                $this->query("SET NAMES 'utf8'");
            }
        }
        else {
            throw new Exception("can not use database {$dbName}.\n");
        }
    }
    public function close() {
        if (mysql_close($this->connection)) {
            throw new Exception("can not close connection\n");
        }
    }
    public function selectFirst($queryString,$assert = false,$resultType = null) {
        $resource = $this->query($queryString);
        $this->queryCount++;
        try {
            $result = $this->fetchArray($resource,$resultType);
        }
        catch(Exception $e) {
            throw new Exception("assert at lest one result,but not.\n");
        }
        return $result;
    }

    public function selectAsArray($queryString, $resultType = null) {
        $resource = $this->query($queryString);
        $array = array();
        $resultType = $resultType === null ? $this->defaultResultType : $resultType;
        $this->queryCount++;
        $temp = mysql_fetch_array($resource,$resultType);
        while($temp !== false) {
            $array[] = $temp;
            $temp = mysql_fetch_array($resource,$resultType);
        }
        return $array;
    }

    public function query($queryString) {
        empty($this->connection) ? $this->connect() : null;
        $this->queryString[] = $queryString;
        $resource = mysql_query($queryString,$this->connection);
        if ($resource === false) {
            throw new Exception("Query String has Error: ".$queryString);
        }
        else {
            return $resource;
        }
    }
    public function insert($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    public function update($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    public function delete($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    private function fetchArray($resource, $resultType = null) {//MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
        $resultType = $resultType === null ? $this->defaultResultType : $resultType;
        $result = mysql_fetch_array($resource,$resultType);
        if ($result === false) {
            throw new Exception("no more rows to fetch\n");
        }
        else {
            return $result;
        }
    }

    public function count($resource) {
        return mysql_num_rows($resource);
    }
    public function countAffectedRows() {
        $result = mysql_affected_rows($this->connection);
        if ($result === -1) {
            throw new Exception("query affectedRows failed;\n");
        }
        else {
            return $result;
        }
    }
    public function affectedRows() {
        return $this->affectRows;
    }
    public function lastInsertId() {
        $result = mysql_insert_id($this->connection);
        if ($result === 0) {
            throw new Exception("no increament id produced.\n");
        }
        else {
            return $result;
        }
    }

    public function error() {
        echo "<pre>Error infomation: [".mysql_errno()."]".mysql_error()."</pre>\n";
    }
}
?>
