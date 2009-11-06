<?php
function getActionUrl($action_name,$action_value) {
    echo "http://localhost/".$_SERVER['PHP_SELF']."?".$action_name."=".$action_value;
}
function getNowDate() {
    echo $date = date("Y-m-d G:i:s");
}
//Categorys
function loadCategorys() {
    global $db_connection;
    return $db_connection->queryAsArray("SELECT category_id,category_name,category_parent_id FROM categorys");
}
function hasCategorys() {
    global $db_connection;
    return $db_connection->hasRow();
}
function getCategorys() {
    global $db_connection;
    return $db_connection->getNextRow();
}
function getCategoryId() {
    global $db_connection;
    echo $db_connection->row_result["category_id"];
}
function getCategoryName() {
    global $db_connection;
    echo $db_connection->row_result["category_name"];
}

function getCategorysTree() {
    function _c_154894($walker) {
        $childnum = 0;
        for ($j = 0; $j < $walker->target_array_length; $j++) {
        //当前根与数组内元素匹配
            if ($walker->target_array[$j]["category_parent_id"] == $walker->current_parent) {
                array_push($walker->excution_stack,$walker->target_array[$j]);
                $childnum++;
            }
        }
        if ($childnum > 0) {
            $walker->depth++;
            echo "<ul>";
            for ($i = 0; $i < $childnum ; $i++) {
                $current_node = array_pop($walker->excution_stack);
                //输出
                $s = "<li>";
                $s .= '<input name="category_id[]" type="checkbox" id="category_id_'.$walker->num++.'" value="';
                $s .= $current_node["category_id"];
                $s .= '" />';
                $s .= $current_node["category_name"];
                $s .= "</li>";
                echo $s;
                //重设根
                $walker->current_parent = $current_node["category_id"];
                //递归
                _c_154894($walker);
            }
            echo "</ul>";
            $walker->depth--;
        }
    }
    $target = loadCategorys();
    $walker = new walker($target);
    $walker->num = 0;
    _c_154894($walker);
}
function getCategoryTree($target_array,$starter,$ender) {
    static $sa;
    if (!isset($sa)) {
        $sa = array(
            "depth" => 0,
            "stack" => array(),
            "pid" => 0,
            "pid_name" => "category_parent_id",
            "id_name" => "category_id"
        );
    }
    $target_array_length = count($target_array);
    $childnum = 0;
    for ($i = 0; $i < $target_array_length; $i++) {
        if ($target_array[$i][$sa["pid_name"]] == $sa["pid"]) {
            if ($childnum == 0) {
                array_push($sa["stack"],"__end");
            }
            array_push($sa["stack"],$target_array[$i]);
            $childnum++;
        }
    }
    if ($childnum > 0) {
        echo $starter;
        $sa["depth"]++;
        $current_node = array_pop($sa["stack"]);
        $sa["pid"] = $current_node[$sa["id_name"]];
        return $current_node;
    }else {
        if ($sa["stack"] !== NULL) {
            $current_node = array_pop($sa["stack"]);
            while ($current_node == "__end") {
                echo $ender;
                $sa["depth"]--;
                $current_node = array_pop($sa["stack"]);
            }
            $sa["pid"] = $current_node[$sa["id_name"]];
            return $current_node;
        }else {
            return false;
        }
    }
}
function getCategoryOption() {
    function _c_1548818($walker) {
        $childnum = 0;
        for ($j = 0; $j < $walker->target_array_length; $j++) {
        //当前根与数组内元素匹配
            if ($walker->target_array[$j]["category_parent_id"] == $walker->current_parent) {
                array_push($walker->excution_stack,$walker->target_array[$j]);
                $childnum++;
            }
        }
        if ($childnum > 0) {
            $walker->depth++;
            for ($i = 0; $i < $childnum ; $i++) {
                $current_node = array_pop($walker->excution_stack);
                //输出
                $s = '<option id="option'.$current_node["category_id"].'" value="';
                $s .= $current_node["category_id"];
                $s .= '">';
                $s .= str_repeat("—",$walker->depth-1).$current_node["category_name"];
                $s .= '</option>';
                echo $s;
                //重设根
                $walker->current_parent = $current_node["category_id"];
                //递归
                _c_1548818($walker);
            }
            $walker->depth--;
        }
    }
    $target = loadCategorys();
    $walker = new walker($target);
    _c_1548818($walker);
}


//tags
//Categorys
function loadTags() {
    global $db_connection;
    return $db_connection->query("SELECT tag_id,tag_name FROM tags");
}
function hasTags() {
    global $db_connection;
    return $db_connection->hasRow();
}
function getTags() {
    global $db_connection;
    return $db_connection->getNextRow();
}
function getTagId() {
    global $db_connection;
    echo $db_connection->row_result["tag_id"];
}
function getTagName() {
    global $db_connection;
    echo $db_connection->row_result["tag_name"];
}
?>