<?php
session_start();
if (isset($_GET['destory'])) {
    session_destroy();
    exit();
}
function scanFilesystem($dir) {
    $tempArray = array();
    $handle = opendir($dir);
    while (false !== ($file = readdir($handle))) {
        if (substr("$file", 0, 1) != ".") {
            if(is_dir("$dir/$file")) {
                $tempArray[$file] = scanFilesystem("$dir/$file");
            } else {
                $tempArray[]= $file;
            }
        }
    }
    closedir($handle);
    return $tempArray;
}
if (!isset($_SESSION['count'])) {
    $array = scanFilesystem('./temp');
    foreach($array as $eachip => $value) {
        foreach($value as $each) {
            //$newArray[$each] = './temp/'.$eachip.'/'.$each;
            $newArray[] = './temp/'.$eachip.'/'.$each;
            $names[] = $eachip.'/'.$each;
        }
    }
    $count = count($newArray);
    $_SESSION['array'] = serialize($newArray);
    $_SESSION['count'] = $count;
    $_SESSION['current'] = 0;
    $_SESSION['name'] = $names;
    touch('./data');
    file_put_contents('./data', serialize(array()));
    echo "<script>window.location.href='./paser.php'</script>";
} else {
    $array = unserialize($_SESSION['array']);
    include($array[$_SESSION['current']]);
    $db = Config::getConfig('db', 'common');
    $mem = Config::getConfig('cache');
    $socketprivate = Config::getConfig('xmlrpc');
    $info = array(
            'safe_level' => _SAFE_LEVEL_,
            'swf_ver' => _SWF_VER_,
            'FCM' => _FCM_ON_,
            'dbhost' => $db['host'],
            'dbname' => $db['db_name'],
            'dbuser' => $db['username'],
            'dbpass' => $db['password'],
            'memhost' => $mem['session']['host'],
            'memport1' => $mem['session']['port'],
            'memport2' => $mem['fight']['port'],
            'socketprivatehost' => $socketprivate['common']['server'],
            'socketpublichost' => _SOCKET_IP_,
            'socketport1' => _SOCKET_PORT_,
            'socketport2' => $socketprivate['common']['port'],
            'web_domain' => _WEB_DOMAIN_,
            'webgw_domain' => _WEBGW_DOMAIN_,
            'pay_domain' => _PAY_DOMAIN_,
            'bbs_domain' => _BBS_DOMAIN_,
            'service_domain' => _SERVER_DOMAIN_,
            'plat_ver' => _PLAT_VER_,
            'game_title' => _GAME_TITLE_,
            'safe_interval' => _SAFE_INTERVAL_,
            'is_yewang' => _IS_YEWAMG_,
            'lastupdate' => date('Y-m-d H:i:s'),
    );
    $data = unserialize(file_get_contents('./data'));
    $data[$_SESSION['name'][$_SESSION['current']]] = $info;
    file_put_contents("./data",serialize($data));
    $_SESSION['current']++;
    if ($_SESSION['current'] < $_SESSION['count']) {
        echo "<script>window.location.href='./paser.php'</script>";
    } else {
        session_destroy();
        echo "<script>window.location.href='./view.php'</script>";
    }
}
?>
