<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current time to check against task due time
$current_time = strtotime(date('Y-m-d H:i:s'));

// Fetch tasks for the logged-in user
$stmt = $conn->prepare("SELECT id, task_name, status, due_time FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

date_default_timezone_set('Asia/Kolkata');

// Automatically mark tasks as completed if their due time has passed
foreach ($tasks as $task) {
    if ($task['status'] == 'pending' && strtotime($task['due_time']) <= $current_time) {
        // Mark task as completed if the due time has passed
        $update_stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
        $update_stmt->bind_param("i", $task['id']);
        $update_stmt->execute();
        $update_stmt->close();
    }
}
$stmt->close();

include 'components/header.php';
?>

<main>
    <div class="dashboard-container">
        <!-- Left Section: Completed Tasks -->
        <div class="dashboard-left">
            <h3>Completed Tasks</h3>
            <?php
            $completed_tasks = array_filter($tasks, fn($task) => $task['status'] === 'completed');
            if (empty($completed_tasks)) {
                echo "<p>No completed tasks.</p>";
            } else {
                echo "<ul>";
                foreach ($completed_tasks as $task) {
                    echo "<li class='task-item completed'>
                            <strong>{$task['task_name']}</strong> - Completed on: {$task['due_time']}
                          </li>";
                }
                echo "</ul>";
            }
            ?>
        </div>

        <!-- Right Section: Pending Tasks (with CRUD actions) -->
        <div class="dashboard-right">
            <h3>Pending Tasks</h3>
            <?php
            $pending_tasks = array_filter($tasks, fn($task) => $task['status'] === 'pending');
            if (empty($pending_tasks)) {
                echo "<p>No pending tasks.</p>";
            } else {
                echo "<ul>";
                foreach ($pending_tasks as $task) {
                    echo "<li class='task-item pending'>
                            <strong>{$task['task_name']}</strong> - Due: {$task['due_time']}
                            <a href='mark_complete.php?task_id={$task['id']}' class='btn-action'>Mark Complete</a>
                          </li>";
                }
                echo "</ul>";
            }
            ?>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?>
