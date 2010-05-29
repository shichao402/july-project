<?php
//定义应用配置路径
define('APP_CONFIG',dirname(__FILE__).'/config');
//定义应用根目录
define('APP_ROOT',dirname(__FILE__));
//定义应用的网站路径
define('APP_PATH',dirname($_SERVER['SCRIPT_NAME']));
//加载配置目录内的配置文件
$self = basename(__FILE__);
if (false !== ($handle = opendir(APP_CONFIG))) {
    while (false !== ($fileName = readdir($handle))) {
        if ($fileName == "." || $fileName == ".." || $fileName == $self) {
            continue;
        } else {
            include APP_CONFIG.'/'.$fileName;
        }
    }
    closedir($handle);
}
unset($self);
?>
