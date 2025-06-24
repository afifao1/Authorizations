<?php
$head_mod = 'index';
require 'vendor/autoload.php';
// echo print_r($_COOKIE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <div class="logo">My Profile</div>
    <div class="nav">
        <a href="exit.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="welcome-card">
        <h1 class="welcome-title">Welcome to your profile!</h1>
        <p class="welcome-text">You have successfully logged in.</p>

        <a href="chat.php">
        <button style="padding: 0.7rem 1.5rem; background-color: #48bb78; color: white; border: none; border-radius: 5px; cursor: pointer;">Go to Chat</button>
        </a>
    </div>
</div>

</body>
</html>