<?php
if(session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}

$errorMessage = array();
if($_POST)
{
    extract($_POST);

    if(strlen(trim($email)) == 0)
    {
        $errorMessage[]= "The email is required.";                
    }
    else
    {
        $user = $app['qBuilder']->selectWhere('user', 's',[
            'email' => $email
        ]);
        if($user > 0)
        {
            if(strlen(trim($password)) > 0)
            {
                if(!password_verify($password, $user['password']))
                {
                    $errorMessage[] = "The passwords do not match.";
                }
            }
            else
            {
                $errorMessage[] = "The password is required.";        
            }
        }
        else
        {
            $errorMessage[] = "This email address is not registred.";        
        }
        if(count($errorMessage) == 0)
        {
            unset($user['password']);
            $_SESSION['user'] = $user;
            $_SESSION['logged'] = true;
        }
    }
}
if(isset($_SESSION['logged']))
{
    require $app['router']->direct('');
}
else
{
    require "views/login.view.php";
}
