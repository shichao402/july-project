<form action ='./addserver.php?submit' method='POST'>
    名字<input name ="name" type="input" size="20" value=""/><br />
    域名<input name ="domain" type="input" size="20" value=""/><br />
    后端ip<input name ="web_ip" type="input" size="100" value=""/><br />
    
    swf版本<input name ="swf_ver" type="input" size="20" value=""/><br />
    游戏名称<input name ="game_title" type="input" size="20" value=""/><br />
    是否自有平台<input name ="is_yewang" type="input" size="10" value=""/><br />
    
    memcache ip<input name ="memcache_ip" type="input" size="20" value=""/><br />
    memcache端口1<input name ="memcache_port1" type="input" size="20" value=""/><br />
    memcache端口2<input name ="memcache_port2" type="input" size="20" value=""/><br />

    socket public ip<input name ="socket_public_ip" type="input" size="20" value=""/><br />
    socket private ip<input name ="socket_private_ip" type="input" size="20" value=""/><br />
    socket port1<input name ="socket_port1" type="input" size="20" value=""/><br />
    socket port2<input name ="socket_port2" type="input" size="20" value=""/><br />

    db public ip<input name ="db_ip" type="input" size="20" value=""/><br />
    db private ip<input name ="private_ip" type="input" size="20" value=""/><br />
    db name<input name ="db_name" type="input" size="50" value=""/><br />

    ftp ip<input name ="ftp_ip" type="input" size="20" value=""/><br />
    ftp path<input name ="ftp_path" type="input" size="50" value=""/><br />

    
    官网<input name ="webgw" type="input" size="200" value=""/><br />
    支付地址<input name ="pay" type="input" size="200" value=""/><br />
    论坛<input name ="bbs" type="input" size="200" value=""/><br />
    客服<input name ="service" type="input" size="200" value=""/><br />

    间隔<input name ="safe_interval" type="input" size="50" value=""/><br />
    平台版本<input name ="plat_ver" type="input" size="50" value=""/><br />

    <input type= 'submit' name ="submit">
</form>
<?php
if (!isset($_GET['submit'])) {
    exit();
}
include '../DB.php';
$dbc = new DB('192.168.0.3', 'xj', 'i*&^hj786hj;#d7(!6', 'xjtest_1');
try {
    $queryString = "SELECT * FROM serverconfig WHERE public_ip = {$_POST['publicip']} AND private_ip = {$_POST['privateip']}";
    $result = $dbc->selectFirst($queryString,true);
    echo "has one record in database\n";
} catch (Exception $e) {
    $queryString = "INSERT INTO serverconfig (`name`, web_ip, `domain`, memcache_ip, memcache_port1, memcache_port2, socket_public_ip, socket_private_ip, socket_port1, socket_port2, ftp_ip, ftp_path, db_public_ip,db_private_ip, db_name, swf_ver, is_yewang, game_title, safe_interval, webgw, pay, bbs, service, plat_ver) VALUES  ('{$_POST['name']}', '{$_POST['web_ip']}', '{$_POST['domain']}', '{$_POST['memcache_ip']}',{$_POST['memcache_port1']}, {$_POST['memcache_port2']}, '{$_POST['socket_public_ip']}', '{$_POST['socket_private_ip']}',{$_POST['socket_port1']}, {$_POST['socket_port2']}, '{$_POST['ftp_ip']}', '{$_POST['ftp_path']}', '{$_POST['db_public_ip']}', '{$_POST['db_private_ip']}','{$_POST['db_name']}', '{$_POST['swf_ver']}', '{$_POST['is_yewang']}', '{$_POST['game_title']}', {$_POST['safe_interval']},'{$_POST['webgw']}', '{$_POST['pay']}', '{$_POST['bbs']}', '{$_POST['service']}', '{$_POST['plat_ver']}')')";
    $dbc->insert($queryString);
    $result = $dbc->affectedRows();
    echo "has insert {$result} record";
}
?>