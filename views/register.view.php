<?php
    $title = "Login";
    require "views/partials/head.php";
?>

<h3>Register</h3>
<ul>
    <?php foreach($errorMessage as $message) : ?>
        <li><?= $message ?></li>
    <?php endforeach; ?>
</ul>
<form action='/register' method="post">
    <div>
        <label>Name</label>
        <input type="text" name="name" required value="<?= $name ?? "" ?>">
    </div>
    <div>
        <label>Lastname</label>
        <input type="text" name="lastName" required value="<?= $lastName ?? "" ?>">
    </div>
    <div>
        <label>E-mail</label>
        <input type="email" name="email" required value="<?= $email ?? "" ?>">
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" required>
    </div>
    <input type="submit" value="Register">
</form>

<?php require "views/partials/foot.php"; ?>