<?php
function __autoload($className) {
    spl_autoload_call($className);
}
function autoloadControler($className) {
    $filePath = 'controlers/'.$className.'.php';
    if (file_exists($filePath)) {
        require($filePath);
    }
}
function autoloadModel($className) {
    $filePath = 'models/'.$className.'.php';
    if (file_exists($filePath)) {
        require($filePath);
    }
}
spl_autoload_register(autoloadControler);
spl_autoload_register(autoloadModel);
?>
