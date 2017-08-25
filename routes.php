<?php

$app['router']->define([
    "" => "controllers/index.php",
    "register" => "controllers/register.php",
    "login" => "controllers/login.php",
    "logout" => "controllers/logout.php",
    "404" => "controllers/notfound.php"
]);