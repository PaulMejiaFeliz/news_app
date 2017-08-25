<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "core/bootstrap.php";

$app['router']= new Router;

require "routes.php";

require $app['router']->direct(trim($_SERVER['REQUEST_URI'], "/"));
