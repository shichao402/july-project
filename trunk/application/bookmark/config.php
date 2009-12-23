<?php
define('APP_CONFIG',dirname(__FILE__).'/config');
define('APP_ROOT',dirname(__FILE__));
define('APP_URL',dirname($_SERVER['SCRIPT_NAME']));
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