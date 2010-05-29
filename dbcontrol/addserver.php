<?php
include './DB.php';
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');

$queryString = "SHOW FULL FIELDS FROM `server_config`";
$result = $db->selectAsArray($queryString);
unset($result[0]);
echo "<form action=\"addserver.php\" method=\"POST\" >";
foreach ($result as $each) {
    echo "<li><span>{$each['Comment']}</span><input name=\"{$each['Field']}\" type=\"text\" value=\"\" /></li>";
    $fields[] = $each['Field'];
}
echo "<input name=\"submit\" type=\"submit\" />";
echo "</form>";
if (isset($_POST['submit'])) {
    unset($_POST['submit']);
    $fieldString = implode("`,`", $fields);
    $valueString = implode("','", $_POST);
    $queryString ="INSERT INTO `server_config`(`{$fieldString}`) VALUES ('{$valueString}')";
    echo $queryString;
    if ($db->insert($queryString) < 1) {
        echo 'failed';
    } else {
        echo 'success';
    }
}
?>