<?php

if (isset($errors) && is_array($errors)) {

    $result = "<div class='alert alert-danger' role='alert'><ul>";

    foreach ($errors as $error) {

        $result .= "<li>" . $error . "</li>";

    }

    $result .= "</ul></div>";

    echo $result;

}