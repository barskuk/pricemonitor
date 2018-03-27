<?php

function __autoload($className) {

    $arrayPath = array(
        '/modules/',
        '/app/',
        '/app/controller/',
        '/app/model/'
    );

    include_once ROOTDIR."/modules/simple_html_dom.php";

    foreach ($arrayPath as $path) {
        $path = ROOTDIR . $path . $className . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}
