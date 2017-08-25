<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News App <?= isset($title)? "- $title" : "" ?></title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <?php if(isset($_SESSION['logged'])) : ?>
            <li>
                <?= "{$_SESSION['user']['name']} {$_SESSION['user']['lastName']}"; ?> 
                (<a href="/logout">Logout</a>)
            </li>
            <?php else : ?>
            <li><a href="/register">Register</a></li>
            <li><a href="/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>