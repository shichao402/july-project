<?php
$count = 10000;
class test {
    private $t = 100;
    public function getT() {
        return $this->t;
    }
    public function __get($name) {
        return $this->{$name};
    }
}
$s =new test();
/***************************************/
ob_start();
$time_start = microtime_float();
for ($i=0; $i<$count; $i++) {
    $s->getT;
}
$time_end = microtime_float();
//echo serialize($wog_arry);
$time = ($time_end - $time_start);
echo "\n Time : $time seconds\n";
ob_flush();
/***************************************/

function timetest() {
    $args = func_get_args();
    $count = $args[0];
    $funcName = $args[1];
    unset($args[0]);
    unset($args[1]);
    $time_start = microtime_float();
    for($i=0;
    $i<$count;
    $i++) {
        call_user_func_array($funcName,$args);
    }
    $time_end = microtime_float();
    $time = $time_end - $time_start;
    echo "\n Time : $time seconds\n";
}
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
?>