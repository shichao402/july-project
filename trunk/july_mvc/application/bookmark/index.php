<?php
include('../../helper/time.php');
$start = microtime_float();
require('../../base/config.php');
require('config/config.php');
Router::parse();
Router::start();
$end = microtime_float();
echo $end-$start;
?>
