<?php
require('../july/model/secache.php');
$cache = new secache;
$cache->workat('../cachedata');
    $cache->fetch(md5(0),$value);
        echo '<li>'.$key.'=>'.$value.'</li>';
?> 