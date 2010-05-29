<script type="text/javascript">
    function compare(node) {
        if (node.getAttribute('oldvalue') != node.value) {
            node.style.backgroundColor = 'FF0000';
        } else {
            node.style.backgroundColor = '';
        }
    }
    function light(node) {
        if (node.checked == true) {
            node.parentNode.parentNode.style.backgroundColor = 'ff0000';
        } else {
            node.parentNode.parentNode.style.backgroundColor = '';
        }
    }
</script>
<?php
include './DB.php';
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$idString = implode(',',$_POST['update']);
$queryString = "SELECT * FROM `server_config` WHERE id IN({$idString})";
$result = $db->selectAsArray($queryString);
?>
<form action="post.php" method="POST">
    <table border="1">
        <thead>
            <tr>
                <?php
                echo "<th>#</th>";
                foreach (current($result) as $key => $each) {
                    echo "<th>{$key}</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach ($result as $row) {
                echo "<tr>";
                $count++;
                echo "<td>{$count}</td>";
                $str = '';
                foreach ($row as $key => $value) {
                    $str .= "<td><input oldvalue=\"{$value}\" onChange=\"compare(this)\" name=\"{$key}[]\" type=\"text\" value=\"{$value}\" /></td>";
                }
                echo $str;
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <input type="submit" />
</form>
