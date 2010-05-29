<?php
include './DB.php';
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$queryString = "SHOW FULL FIELDS FROM `server_config`";
$fields = $db->selectAsArray($queryString);
unset($fields[0]);
$queryString = "SELECT * FROM `server_config`";
$result = $db->selectAsArray($queryString);
?>
<form action="update.php" method="POST">
    <table border="0" cellspacing="2" cellpadding="2">
        <thead>
            <tr>
                <th>#</th>
                <th>update</th>
                <?php
                foreach ($fields as $field) {
                    echo "<th>{$field['Field']}</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($result as $each) {
                echo '<tr>';
                echo "<td>{$count}</td>";
                $count++;
                foreach ($each as $key => $value) {
                    if ($key == 'id') {
                        echo "<td><input onclick=\"parentNode.parentNode.style.backgroundColor = this.checked==true ? 'FF0000' : '' \" type=\"checkbox\" name=\"update[]\" value=\"{$value}\" /></td>";
                    } else {
                        echo "<td>$value</td>";
                    }
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <input type="submit" />
</form>
