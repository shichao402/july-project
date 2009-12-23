<?php
require_once("../include/db.class.php");
require_once("../include/template_admin.php");

class category {
    private $name;
    private $id;

    private $slug;
    private $desc;
    private $pid;
    private $id_name;
    private $pid_name;
    private $target;
    private $stack = array();
    function setName($name) {
        $this->name = $name;
    }
    function getName() {
        return $this->name;
    }
    function setId($id) {
        $this->id = $id;
    }
    function getId() {
        return $this->id;
    }
    function setSlug($slug) {
        $this->slug = $slug;
    }
    function getSlug() {
        return $this->slug;
    }
    function setDesc($desc) {
        $this->desc = $desc;
    }
    function getDesc() {
        return $this->desc;
    }
    function setPid($pid) {
        $this->pid = $pid;
    }
    function getPid() {
        return $this->pid;
    }
    function setPointer() {
        $target = $this->getTarget();
    }
    function setStack($pid = NULL) {
        if ($pid === NULL) {$pid = &$this->pid; }
        $temp = $this->getChildsAndNum($pid);
        $this->stack[$pid] = array(
            "child" => $temp[0],
            "total" => $temp[1],
            "fetched" => 0
        );
    }
    function unsetStack($pid = NULL) {
        if ($pid === NULL) {$pid = &$this->pid; }
        unset($this->stack[$pid]);
    }
    function getStackNum() {
        return count($this->stack);
    }
    //压入堆栈,返回压入数目
    function push($array) {
        $n = count($array);
        for ($i = 0;$i < $n;$i++) {
            array_push($this->stack,$array[$i]);
        }
        return $n;
    }
    function pop() {
        return array_pop($this->stack);
    }
    function checkStack() {
        if ($this->stack != NULL) {
            return true;
        }else {
            return false;
        }
    }
    function getStack() {
        return $this->stack;
    }
    function setIdName($id_name) {
        $this->id_name = $id_name;
    }
    function getIdName() {
        return $this->id_name;
    }
    function setPidName($pid_name) {
        $this->pid_name = $pid_name;
    }
    function getPidName() {
        return $this->pid_name;
    }
    //pid是设置的父级ID,pid_name是将要与pid匹配的target数组中的字段名字
    function getChildsAndNum($pid = NULL,$pid_name = NULL) {
        if ($pid === NULL) {$pid = &$this->pid; }
        if ($pid_name === NULL) {$pid_name = &$this->pid_name;}
        $length = $this->getTargetLength();
        for ($i = 0; $i < $length; $i++) {
            if ($pid == $this->target[$i][$pid_name]) {
                $temp_array[] = $this->target[$i];
                $num++;
            }
        }
        return array($temp_array,$num);
    }
    function setFetchedNum($fetched_num) {
        $this->stack[$this->getPid()]["fetched"] = $fetched_num;
        return $this->getFetchedNum();
    }
    function getFetchedNum() {
        return $this->stack[$this->getPid()]["fetched"];
    }
    function getChilds() {
        return $this->stack[$this->getPid()]["child"];
    }
    function getChildsNum() {
        return $this->stack[$this->getPid()]["total"];
    }
    function setTarget($target) {
        $this->target = $target;
    }
    function getTarget() {
        return $this->target;
    }
    function getTargetLength() {
        return count($this->target);
    }
    function nextRow() {
        $total = $this->getChildsNum();
        $num = $this->getFetchedNum();
        $num = $this->setFetchedNum($num + 1);
        if ($num >= $total) {
            $this->unsetStack();
            return false;
        }
        return $num;
    }
    function getRow() {
        $childs = $this->getChilds();
        $total = $this->getChildsNum();
        $num = $this->getFetchedNum();
        return $this->target[$childs[$num]];
    }
}
function f($_id,$_targetArray,$_level) {
    foreach($_targetArray as $v) {
        if ($v["category_parent_id"] == $_id) {
            echo "<ul>";
            break;
        }
    }
    foreach($_targetArray as $v) {
        if ($v["category_parent_id"] == $_id) {
            echo "<li>";
            echo $v["category_id"];
            echo ":";
            echo $v["category_name"];
            echo "</li>";
            f($v["category_id"],$_targetArray,$_level + 1);
        }
    }
    foreach($_targetArray as $v) {
        if ($v["category_parent_id"] == $_id) {
            echo "</ul>";
            break;
        }
    }
}

echo $i;
if ($_GET["action"] == "add" ) {
    $fields = array(
        "category_id" 	=> $_POST["category_id"],
        "category_name" => $_POST["category_name"],
        //----临时使用name作为slug---------
        "category_slug" => $_POST["category_name"],
        //---------------
        "category_desc" => $_POST["category_desc"],
        "category_parent_id" 	=> $_POST["category_parent_id"],
    );



    //insert category
    $keys = implode(",",array_keys($fields));
    $values = array_values($fields);
    $size = count($values);
    for ($i = 0;$i < $size;$i++) {
        if ($values[$i] == NULL) {
            $values[$i] = 'NULL';
        }else {
            $values[$i] = "'".$values[$i]."'";
        }
    }
    $values = implode(",",$values);

    $q = "INSERT INTO categorys ";
    $q .= "($keys)";
    $q .= "VALUES ";
    $q .= "($values)";

    $r = $db_connection->query($q);
    echo $q;
    echo "<br />";
    echo $r;
}
if ($_GET["action"] == "del" ) {
    $category_id = $_GET["category_id"];
    $r = $db_connection->query("DELETE FROM `categorys` WHERE `category_id` = '$category_id';");
    echo $r;
}
if ($_GET["action"] == "edit" ) {
    $category_id = $_GET["category_id"];
    if (isset($_POST["category_id"])) {
        $fields = array(
            "category_id" 	=> $_POST["category_id"],
            "category_name" => $_POST["category_name"],
            //----临时使用name作为slug---------
            "category_slug" => $_POST["category_slug"],
            //---------------
            "category_desc" => $_POST["category_desc"],
            "category_parent_id" 	=> $_POST["category_parent_id"],
        );
        $q = "UPDATE `categorys` SET ";
        $q .= "`category_name`='".$fields["category_name"]."',`category_slug`='".$fields["category_slug"]."',`category_desc`='".$fields["category_desc"]."' WHERE `category_id`='".$fields["category_id"]."'";
        $r = $db_connection->query($q);
        echo $r;
    }else {
        $q = "SELECT * FROM `categorys` WHERE `category_id` = '".$category_id."'";
        $r = $db_connection->query($q);
        $r = $db_connection->getNextRow();
        include("template/category/edit.php");
    }
}
include("template/category/add.php");

?>