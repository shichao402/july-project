<?php
/**
 * actionlist
 *
 *  show bookmark by id
 *  show bookmarklist
 *      where none|categoryid|tagid|visitcount
 *      order by visitcount|adddate|modifieddate|category|tag|url|name
 *      limit
 *  search bookmarklist
 *      by url|name|desc|modifieddate|adddate
 */

class view {
    private $data = null;
    private $dataStack = array();
    private $currentData = null;
    private $currentKey = null;
    private $currentPointer = 0;
    private $currentLength = 0;
    public function __construct() {
        
    }
    public function initData($data) {
        $this->data = $data;
    }
    public function have() {
        return $this->currentPointer+1 < $this->currentLength;
    }
    public function next() {
        $this->currentPointer+1 >= $this->currentLength ? null : $this->currentPointer++;
    }
    public function choose($nodeName) {
        if (in_array($nodeName, $this->dataStack)) {
            $this->currentData = $this->dataStack[$nodeName];
        }elseif(in_array($nodeName, $this->data)) {
            $this->currentData = $this->data[$nodeName];
        }else {
            throw new Exception('node not exist.');
        }
        $this->currentKey = $nodeName;
        $this->currentPointer = 0;
        $this->currentLength = count($this->currentData);
    }
    public function remove($nodeName = null) {
        if ($nodeName === null) {
            $nodeName = $this->currentKey;
        }
        $this->currentData = null;
        $this->currentKey = null;
        $this->currentPointer = 0;
        $this->currentLength = 0;
        if (in_array($nodeName, $this->dataStack)) {
            unset($this->dataStack[$nodeName]);
        }
        if (in_array($nodeName, $this->data)) {
            unset($this->data[$nodeName]);
        }
    }
    public function currentData() {
        return $this->currentData;
    }
    public function data() {
        return $this->data;
    }
    public function loadView($viewName) {
        if (file_exists('../view/'.$viewName.'.php')) {
            $this->view[$viewName] = '../view/'.$viewName.'.php';
        }
        extract($this->data);
        include($this->view[$viewName]);
    }
}
class controller {
    public function __construct() {
        
    }
    public function render() {
        $this->view->setData($this->data);
    }
    function bookmarkList() {
        $bookmark = new BookMark();
//        $bookmark->setPage($page);
//        $bookmark->setLimit($count);
//        $bookmark->setOrder($order);
        //$category = new Category();
        //$tag = new Tag();
        
        $this->data['bookmarkList'] = $bookmark->getBookmarks();
        foreach ($this->data['bookmarkList'] as $value) {
            $bookmarkIdArray[] = $value['id'];
        }
//        $this->data['bookmarkCategroyList'] = $category->list($bookmarkIdArray);
//        $this->data['bookmarkTagList'] = $tag->list($bookmarkIdArray);
        
        $this->loadView('bookmarkList');
        $this->render();  //transfer data to template with $data
        $this->view();
    }
}
class BookMark {
    private $DB;
    public function __construct() {
        $this->DB = new Mysql('localhost', 'root', 'root', 'bookmark');
    }
    public function getBookmarks() {
        $page = 1;
        $length = 10;
        $offset = ($page-1)*$length;
        return $this->DB->queryArray("SELECT * FROM bookmark LIMIT {$offset},{$length}");
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
$test = new controller();
$test->bookmarkList();
class Mysql {

    protected $err_report = true;

    protected $conn;

    protected $queryCount;

    public function __construct($dbHost = DB_HOST, $dbUser = DB_USER, $dbPass = DB_PWD, $dbName = DB_NAME) {
        $this->connect($dbHost, $dbUser, $dbPass, $dbName);
    }

    public function connect($dbHost = DB_HOST, $dbUser = DB_USER, $dbPass = DB_PWD, $dbName = DB_NAME) {

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

    public function queryArray($queryString, $type = MYSQL_ASSOC) {

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

}
class DB {
    static private $db = null;
    private $engine = null;
    static public function db() {
        if (empty(self::$db)) {
            self::$db = self::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        }
    }
    static public function connect($host,$user,$pass,$dbname) {
        self::$db = new ${self::$engine}($host,$user,$pass,$dbname);
    }
    static public function setEngine($engineName) {
        self::$engine = $engineName;
    }
}