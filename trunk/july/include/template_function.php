<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function check($id,$targetArray) {
    foreach($targetArray as $v) {
        if ($v["category_pid"] == $id) {
            return true;
        }
    }
    return false;
}
function showCategoryTree($id,$targetArray,$level) {
    if (check($id,$targetArray)) {
        echo "<ul>";
        foreach($targetArray as $v) {
            if ($v["category_pid"] == $id) {
                echo "<li>";
                echo '<a href="',ROOT,'index.php?categoryid=',$v["category_id"],'">',$v["category_name"],'</a>';
                echo "</li>";
                if (check($v["category_id"],$targetArray)) {
                    echo "<li>";
                    showCategoryTree($v["category_id"],$targetArray,$level + 1);
                    echo "</li>";
                }
            }
        }
        echo "</ul>";
    }
}
?>
