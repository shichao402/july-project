<?php
session_cache_expire(5);
session_start();

echo session_id();
// Use $HTTP_SESSION_VARS with PHP 4.0.6 or less
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
} else {
    $_SESSION['count']++;
}
$_SESSION['count2'] = array();
var_dump($_SESSION,session_encode());
?>