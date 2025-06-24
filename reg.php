<?php
require 'db.php';
$head_mod = 'auth';
require 'vendor/autoload.php';

if (isset($_POST['submit'])){
    $username = isset($_POST['username']) ? $_POST['username'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;
	
	if (empty($username) OR empty($password)){
		$error = 'Please fill in all fields';
	}

    if(empty($error)){
		$db->conn->query("INSERT INTO `users` SET
			`username` = '".$db->conn->real_escape_string($username)."',
			`password` = '".$db->conn->real_escape_string($password)."'
		");

        $user_id = $db->conn->insert_id;

        setcookie('user_id', $user_id, time() + 3600, '/');
        header('Location: index.php');
        exit;
    } else {
        $error = "Registration failed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <div class="logo">Register</div>
</div>

<div class="container">
    <?php if (isset($error)): ?>
        <div class="alert alert-success"><?= $error ?></div>
    <?php endif; ?>

    <div class="welcome-card">
        <h1 class="welcome-title">Register</h1>
        <form action="/reg.php" method="POST">
            <input type="text" name="username" placeholder="Username" required style="padding: 0.5rem; width: 100%; margin-bottom: 1rem;"><br>
            <input type="password" name="password" placeholder="Password" required style="padding: 0.5rem; width: 100%; margin-bottom: 1rem;"><br>
            <button type="submit" name="submit" style="padding: 0.7rem 1.5rem; background-color: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">Register</button>
        </form>
        <p style="margin-top: 1rem;">Already have an account? <a href="login.php" style="color: #667eea;">Login</a></p>
    </div>
</div>

</body>
</html>