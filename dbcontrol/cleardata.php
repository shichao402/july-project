<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
</head>
  <body>
<?php
if ($_GET['tell'] != 'aishiteru') {
    exit('ohxiete');
}
$privateData = array(
    'alias',
    'active_qa',
    'build_level',
    'card_number',
    'card_type',
    'friend_group',
    'guild_syn',
    'inner_background',
    'item',
    'item_appr',
    'item_syn',
    'map',
    'map_monster',
    'monster',
    'npc',
    'pet_astr',
    'pet_defaultmain',
    'pet_exp',
    'pet_guardmain',
    'pet_skill',
    'player_exp',
    'rmb_shop',
    'shop',
    'skill',
    'skill_level',
    'sysinfo',
    'sysTipMsg',
    'task',
    'tre_cornucopia',
    'tre_depot',
    'tre_fate',
    'treasure',
);
if (isset($_POST['submited']) && $_SESSION['submited'] != true) {
    $_SESSION['submited'] = true;
    if ($_POST['code'] != $_SESSION['code']) {
        exit('invalid code');
    }
    ob_start();
    require '../../Application/Config/Config.php';
    require './DB.php';
    $dbinfo = Config::getConfig('db', 'common');
    $link = mysql_connect($dbinfo['host'], $dbinfo['username'], $dbinfo['password']) or die('connect error.');
    $db = new DB($dbinfo['host'], $dbinfo['username'], $dbinfo['password'], $dbinfo['db_name']);
    $resources = $db->query('SHOW TABLES');
    while ($each = mysql_fetch_array($resources)) {
        $result[] = $each[0];
    }
    echo '<pre>';
    $diff = array_diff($result, $privateData);
    //var_dump($privateData,$result,array_diff($result,$privateData));
    foreach ($diff as $each) {
        echo "delete from `{$each}`...";
        $db->delete("DELETE FROM `{$each}`");
        ob_flush();
        if ($db->affectedRows() >= 0) {
            echo "sucess delete rows: ".$db->affectedRows()."\n";
        } else {
            echo "failed\n";
        }
        echo "reset auto_increatment from `{$each}`...done\n";
        $db->delete("ALTER TABLE `{$each}` AUTO_INCREMENT=0");
        ob_flush();
    }
    echo '</pre>';
}else {
    $_SESSION['submited'] = false;
    for ($i = 4;$i>0;$i--) {
        $code .= (string) rand(0,9);
    }
    $_SESSION['code'] = $code;
    echo "<pre>清空除了以下数据表以外的所有数据:";
    echo implode("\n",$privateData);
    echo "</pre>$code";
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>?tell=aishiteru" method="POST">
    <input type="input" id="code" name="code" />
    <input type="hidden" name ="submited" />
    <input type="submit" />
</form>
<?php
}
?>
  </body>
</html>