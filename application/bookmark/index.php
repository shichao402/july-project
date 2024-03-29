<?php
error_reporting(7);
xhprof_enable();
require('/var/www/july/july/July.php');
require './config.php';
try {
    $july = July::instance();
    $cache = new Cache(APP_ROOT.'/cache');
    $july->autoload->setIndex($cache->get('autoload_index'));
    $july->db = new DB(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    $july->router->setDefaultRoute($default_route);
    $july->run();
} catch (FileSystemException $e) {
    echo $e->getMessage();
    echo "try to rebuildindex\n";
    try {
        $july->autoload->addPath($folder);
        $july->autoload->buildIndex();
        $cache->set('autoload_index',$july->autoload->getPathIndex());
    } catch (FileSystemException $e) {
        echo $e->getMessage();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
$xhprof_data = xhprof_disable();
$XHPROF_ROOT = '/var/www/xhprof';
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
echo "---------------\n".
        "<a href=\"http://192.168.128.128/xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_foo\">show</a>\n".
        "---------------\n";

?>
