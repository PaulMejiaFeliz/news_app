<?php

$router = App::get('router');
$router->get("", "Home@index");
$router->get("logout", "Acount@logout");
$router->get("login", "Acount@login");
$router->get("register", "Acount@register");
$router->get("newPost", "Home@newPost");
$router->get("postDetails", "Home@postDetails");

$router->post("login", "Acount@loginPost");
$router->post("register", "Acount@registerPost");
$router->post("newPost", "Home@newPost");
