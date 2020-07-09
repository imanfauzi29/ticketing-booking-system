<?php

spl_autoload_register(function ($class) {
    $class = explode("\\", $class);
    echo $class;
    $class = end($class);
    require_once __DIR__ . "/Ticket/" . $class . ".php";
});
