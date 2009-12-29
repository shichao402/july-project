<?php
require '/var/www/july/july/July.php';
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
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
