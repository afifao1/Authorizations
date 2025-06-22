<?php
if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
