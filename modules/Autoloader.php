<?php

function __autoload($className) {

    $arrayPath = array(
        '/modules/',
        '/app/',
        '/app/controller/',
        '/app/model/'
    );

    foreach ($arrayPath as $path) {
        $path = ROOTDIR . $path . $className . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}