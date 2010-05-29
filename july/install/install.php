<?php
require_once(JULY_ROOT.'/core/Cache.php');
require_once(JULY_ROOT.'/core/Viewer.php');
require_once(JULY_ROOT.'/core/DataProvider.php');
require_once(JULY_ROOT.'/core/Autoload.php');
require_once(JULY_ROOT.'/core/Router.php');
require_once(JULY_ROOT.'/core/Controler.php');
switch ($_GET['m']) {
    case 'autoloadindex':
        include '';
        $cache = new Cache(JULY_ROOT.'/cache');
        $autoload = new Autoload();
        $autoload->addPath($pathArray);
}
?>
