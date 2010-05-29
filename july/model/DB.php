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
    /**
     * conncet to server
     */
    public function connect() {
        $this->connection = mysql_connect($this->host, $this->user, $this->pass);
        if ($this->connection === false) {
            $this->connection = null;
            throw new DBException("can not connect to mysql.\n");
        } else {
            if (!mysql_select_db($this->name, $this->connection)) {
                throw new DBException("can not use database {$dbName}.\n");
            } else {
                if ((float) substr(mysql_get_server_info($this->connection),0,3) > 4.1) {
                    $this->query("SET NAMES 'utf8'");
                }
            }
        }
    }
    /**
     *  use database
     * @param sting $dbName
     */
    public function useDB($dbName) {
        if (mysql_select_db($dbName, $this->connection)) {
            $this->name = $dbName;
            if ((float) substr(mysql_get_server_info($this->connection),0,3) > 4.1) {
                $this->query("SET NAMES 'utf8'");
            }
        } else {
            throw new DBException("can not use database.\n database name: {$dbName}.\n");
        }
    }
    /**
     * close connection
     */
    public function close() {
        if (!mysql_close($this->connection)) {
            throw new DBException("can not close connection\n");
        }
    }
    /**
     *  select the first row
     * @param SQLSting $queryString
     * @param boolean $assert
     * @param mysql_fetch_type $resultType
     * @return array
     * use $querySting to get an array.while $assert set true means you assert that the return has only one row.
     */
    public function selectFirst($queryString,$assert = false,$resultType = null) {
        $resource = $this->query($queryString);
        $this->queryCount++;
        $result = $this->fetchArray($resource,$resultType);
        if ($result === false) {
            throw new DBException("assert at lest one result,but not.\n");
        } else {
            return $result;
        }
    }
    /**
     *  select rows as array
     * @param SQLSting $queryString
     * @param mysql_fetch_type $resultType
     * @return array
     * 
     */
    public function selectAsArray($queryString, $resultType = null) {
        $resource = $this->query($queryString);
        $array = array();
        $this->queryCount++;
        while(($temp = $this->fetchArray($resource,$resultType)) !== false) {
            $array[] = $temp;
        }
        return $array;
    }
    /**
     *  execute a query,return the resource
     * @param SQLString $queryString
     * @return resource
     */
    public function query($queryString) {
        empty($this->connection) ? $this->connect() : null;
        $this->queryString[] = $queryString;
        $resource = mysql_query($queryString,$this->connection);
        if ($resource === false) {
            throw new DBException(mysql_error($this->connection),mysql_errno($this->connection));
        } else {
            return $resource;
        }
    }
    /**
     *  insert
     * @param SQLString $queryString
     * @return num
     * this will return the count of affected rows after query successful,and the rows num will be store in this object temporary
     */
    public function insert($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    /**
     *  update
     * @param SQLString $queryString
     * @return num
     * as insert
     */
    public function update($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    /**
     *  delete
     * @param SQLString $queryString
     * @return num
     * as insert
     */
    public function delete($queryString) {
        $this->query($queryString);
        $this->affectRows = $this->countAffectedRows();
        return $this->affectRows;
    }
    /**
     *  db result resource to array
     * @param resource $resource
     * @param fetch_type $resultType could be MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
     * @return array
     */
    private function fetchArray($resource, $resultType = null) {//MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
        $resultType = $resultType === null ? $this->defaultResultType : $resultType;
        $result = mysql_fetch_array($resource,$resultType);
        if ($result === false) {
            return false;
        } else {
            return $result;
        }
    }
    /**
     *  count the resource
     * @param resource $resource
     * @return int
     * resource must be a result of "select"
     */
    public function count($resource) {
        return mysql_num_rows($resource);
    }
    /**
     *  count the rows affected in the last query,just like insert update delete
     * @return int
     */
    public function countAffectedRows() {
        $result = mysql_affected_rows($this->connection);
        if ($result === -1) {
            throw new DBException("query affectedRows failed;\n");
        } else {
            return $result;
        }
    }
    /**
     *  get affected Rows number which saved in this object
     * @return int
     */
    public function affectedRows() {
        return $this->affectRows;
    }
    /**
     *  get the insertId in the last insert query.
     * @return int
     */
    public function lastInsertId() {
        $result = mysql_insert_id($this->connection);
        if ($result === 0) {
            throw new DBException("no increament id produced.\n");
        } else {
            return $result;
        }
    }
}
?>
