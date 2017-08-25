<?php

if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

$errorMessage = array();

if($_POST)
{
    extract($_POST);
    $user = count($app['qBuilder']->selectWhere('user', 's',[
        'email' => $email
    ]));
    if($user != 0)
    {
        $errorMessage[] = "This email address is not available.";        
    }
    if(strlen(trim($password)) >= 5)
    {
        if($password == $confirmPassword)
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        else
        {
            $errorMessage[] = "The passwords do not match.";
        }
    }
    else
    {
        $errorMessage[] = "The password must have at least 5 charcters.";        
    }
    if(strlen(trim($name)) == 0)
    {
        $errorMessage[] = "The name is required.";                
    }
    if(strlen(trim($lastName)) == 0)
    {
        $errorMessage[] = "The lastname is required.";                
    }
    if(strlen(trim($email)) == 0)
    {
        $errorMessage[] = "The email is required.";                
    }
    if(count($errorMessage) == 0)
    {
        $app['qBuilder']->insert("user", "ssss", [
            "name" => $name,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $password
        ]);

        $name = "";
        $lastName = "";
        $email = "";
        $password = "";
    }
}
if(isset($_SESSION['logged']))
{
    require $app['router']->direct('');
}
else
{
    require "views/register.view.php";
}
