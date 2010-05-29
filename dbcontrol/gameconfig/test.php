<?php
include '../DB.php';
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$data = unserialize(file_get_contents('./data'));
foreach ($data as $key => $value) {
    list($ftp_ip,$ftp_path) = explode('/',$key);
    $ftp_path = '/home/xj/webapps/'.$ftp_path;
    extract($value, EXTR_OVERWRITE);
    $temp = explode(' ',$game_title);
    $web_domain = substr($web_domain, 7,-1);
    $domain_ip = gethostbyname($web_domain);
    $queryString = "INSERT INTO `server_config`
    (`platform_name`,`server_number`,`server_name`,`domain`,`domain_ip`,`ftp_ip`,`ftp_path`,`ftp_user`,`ftp_password`,`memcache_public_ip`,`memcache_private_ip`,`memcache_port1`,`memcache_prot2`,`socket_public_ip`,`socket_private_ip`,`socket_port1`,`socket_prot2`,`db_public_ip`,`db_private_ip`,`db_user`,`db_password`,`db_name`,`web_nodes_ip`,`sync_address`,`safe_level`,`swf_ver`,`FCM`,`plat_ver`,`safe_interval`,`is_yewang`,`title`,`webgw_domain`,`pay_domain`,`bbs_domain`,`gcs_domain`) VALUES
    ('$game_title','$game_title','$game_title','$web_domain','$domain_ip','$ftp_ip','$ftp_path','xj','ju8$#%^8kmj,)@qamv','$memhost','$memhost','$memport1','$memport2','$socketpublichost','$socketprivatehost','$socketport1','$socketport2','$dbhost','$dbhost','xj','i*&^hj786hj;#d7(!6','$dbname','web_nodes_ip','http://{$ftp_ip}:8088/cgi-bin/tb.pl','$safe_level','$swf_ver','$FCM','$plat_ver','$safe_interval','$is_yewang','$game_title','$webgw_domain','$pay_domain','$bbs_domain','$service_domain')";
    $db->insert($queryString);
}
echo "done";
?>
