<?php
require '/var/www/july/july/July.php';
require './config.php';
try {
    $july = July::instance();
    $july->autoload->setIndex($july->cache->get('autoload_index'));
    $july->db = new DB(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    $july->router->setDefaultRoute($default_route);
    $july->run();
} catch (FileSystemException $e) {
    echo $e->getMessage();
    try {
        $july->autoload->addPath($folder);
        $july->autoload->buildIndex();
        $july->cache->set('autoload_index',$july->autoload->getPathIndex());
    } catch (FileSystemException $e) {
        echo $e->getMessage();
        echo "try to delete cache files and rebuildindex manually\n";
    }
} catch (DBException $e) {
    echo $e->getMessage();
    var_dump($july->db->queryString);
}
?>
