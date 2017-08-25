<?php
    $title = "Login";
    require "views/partials/head.php";
?>

<h3>Login</h3>
<ul>
    <?php foreach($errorMessage as $message) : ?>
        <li><?= $message ?></li>
    <?php endforeach; ?>
</ul>
<form action='/login' method="post">
    <div>
        <label>E-mail</label>
        <input type="email" name="email" required value="<?= $email ?? "" ?>">
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <input type="submit" value="Login">
</form>

<?php require "views/partials/foot.php"; ?>