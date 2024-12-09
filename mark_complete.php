<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['task_id'])) {
    header("Location: login.php");
    exit();
}

$task_id = $_GET['task_id'];

// Ensure the task belongs to the logged-in user
$stmt = $conn->prepare("SELECT user_id FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if ($user_id !== $_SESSION['user_id']) {
    // If the task doesn't belong to the logged-in user, redirect them
    header("Location: dashboard.php");
    exit();
}

// Mark the task as completed
$update_stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
$update_stmt->bind_param("i", $task_id);
$update_stmt->execute();
$update_stmt->close();

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();
