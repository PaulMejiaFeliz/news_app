<?php

if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

if(isset($_SESSION['logged'])){
    session_unset();
    session_destroy();
}

require $app['router']->direct('login');