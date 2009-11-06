<?php
$base = dirname(__FILE__).'/';
if (!file_exists($base.'Router.php')) {
    throw new Exception('no file:Router.php');
}else {
    require ($base.'Router.php');
}
if (!file_exists($base.'base.php')) {
    throw new Exception('no file:base.php');
}else {
    require ($base.'base.php');
}
if (!file_exists($base.'DB.php')) {
    throw new Exception('no file:DB.php');
}else {
    require ($base.'DB.php');
}
if (!file_exists($base.'Autoload.php')) {
    throw new Exception('no file:Autoload.php');
}else {
    require ($base.'Autoload.php');
}

View::init();
?>
