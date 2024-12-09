<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task Reminder System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Task Reminder System</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="tasks.php">Manage Tasks</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
