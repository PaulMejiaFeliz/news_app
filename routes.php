<?php

$router = App::get('router');
$router->get("", "Home@index");
$router->get("logout", "Acount@logout");
$router->get("login", "Acount@login");
$router->get("register", "Acount@register");
$router->get("newPost", "Home@newPost");
$router->get("postDetails", "Home@postDetails");
$router->get("deletePost", "Home@deletePost");
$router->get("editPost", "Home@editPost");

$router->post("login", "Acount@loginPost");
$router->post("register", "Acount@registerPost");
$router->post("newPost", "Home@postNewPost");
$router->post("editPost", "Home@postEditPost");
$router->post("addComment", "Comments@addComment");
$router->post("editComment", "Comments@editComment");
$router->post("deleteComment", "Comments@deleteComment");
