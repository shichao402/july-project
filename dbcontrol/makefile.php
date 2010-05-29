<?php
ob_start();
include './DB.php';
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$queryString = "SELECT `id`,`socket_public_ip`,`socket_port1`,`socket_port2`,`domain`,`plat_ver` FROM `server_config` WHERE socket_port1 != ''";
$info = $db->selectAsArray($queryString);
foreach ($info as $each) {
    $plat_ver = $each['plat_ver'];
    $socket_public_ip = $each['socket_public_ip'];
    $socket_port1 = $each['socket_port1'];
    $socket_port2 = $each['socket_port2'];
    $domain = $each['domain'];
    include './chatserver.tac.template';
    $data = ob_get_contents();
    ob_clean();
    if (!file_exists("./chatserver/$socket_public_ip")) {
        mkdir("./chatserver/$socket_public_ip");
    } else {
        //echo "./chatserver/$socket_public_ip";
    }
    if (!file_exists("./chatserver/$socket_public_ip/$domain")) {
        mkdir("./chatserver/$socket_public_ip/$domain");
    } else {
        //echo "./chatserver/$socket_public_ip/$domain";
    }
    if (!file_put_contents("./chatserver/$socket_public_ip/$domain/chatserver.tac", $data)) {
        exit('false;');
    }
}
?>
