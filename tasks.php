<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $due_time = trim($_POST['due_time']);
    $error = '';

    if (empty($task_name) || empty($due_time)) {
        $error = "Please fill in all fields.";
    } else {
        // Insert the task into the database
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, status, due_time) VALUES (?, ?, 'pending', ?)");
        $stmt->bind_param("iss", $_SESSION['user_id'], $task_name, $due_time);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error occurred while adding the task.";
        }
        $stmt->close();
    }
}

include 'components/header.php';
?>

<main>
    <h2>Add a New Task</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div>
            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required>
        </div>
        <div>
            <label for="due_time">Due Time:</label>
            <input type="datetime-local" id="due_time" name="due_time" required>
        </div>
        <button type="submit">Add Task</button>
    </form>
</main>

<?php include 'components/footer.php'; ?>
