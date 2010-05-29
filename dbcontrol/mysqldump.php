<?php
include './DB.php';
$id=$_POST['id'];
$path = trim($_POST['path']);
$backupPath = trim($_POST['backuppath']);
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$queryString = "SELECT `db_public_ip`,`db_user`,`db_password`,`db_name` FROM `server_config` WHERE id = {$id}";
$dbinfo = $db->selectFirst($queryString, true);
//$command = "/usr/local/mysql/bin/mysqldump --default-character-set=utf8 -h {$dbinfo['db_public_ip']} -u{$dbinfo['db_user']} -p\"{$dbinfo['db_password']}\" {$dbinfo['db_name']} < {$path}";
$command = "/usr/local/mysql/bin/mysql --default-character-set=utf8 -h {$dbinfo['db_public_ip']} -u{$dbinfo['db_user']} -p\"{$dbinfo['db_password']}\" {$dbinfo['db_name']} < {$path}";
system($command,$r);
echo "$r";
?>