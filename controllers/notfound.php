<?php

if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

require "views/notfound.view.php";