<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    App::get('router')->direct('login');
} else {
    if (!$_POST) {
        require "views/newPost.view.php";
    } else {
        App::get('router')->direct("post?id=");
    }
}
