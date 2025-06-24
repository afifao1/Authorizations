<?php
require 'db.php';
$head_mod = 'auth';
require 'vendor/autoload.php';

if (isset($_POST['submit'])){
    $username = isset($_POST['username']) ? $_POST['username'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;

    $result = $db->conn->query("SELECT `id`, `username`, `password` FROM `users` WHERE `username` = '".$db->conn->real_escape_string($username)."' AND `password` = '".$db->conn->real_escape_string($password)."'");

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        setcookie('user_id', $user['id'], time() + 3600, '/');
        header('Location: index.php');
        exit();
    } else {
        $error = "Username or password incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <div class="logo">Login</div>
</div>

<div class="container">
    <?php if (isset($error)): ?>
        <div class="alert alert-success"><?= $error ?></div>
    <?php endif; ?>

    <div class="welcome-card">
        <h1 class="welcome-title">Login</h1>
        <form action="/login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required style="padding: 0.5rem; width: 100%; margin-bottom: 1rem;"><br>
            <input type="password" name="password" placeholder="Password" required style="padding: 0.5rem; width: 100%; margin-bottom: 1rem;"><br>
            <button type="submit" name="submit" style="padding: 0.7rem 1.5rem; background-color: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">Login</button>
        </form>
        <p style="margin-top: 1rem;">Don't have an account? <a href="reg.php" style="color: #667eea;">Register</a></p>
    </div>
</div>

</body>
</html>