<?php
// Start session to check if the user is logged in
session_start();
?>

<?php include 'components/header.php'; ?>

<main>
    <h2>Welcome to Task Reminder System</h2>
    <p>Organize your tasks, track deadlines, and boost your productivity!</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <p><a href="register.php">Get Started by Registering</a> or <a href="login.php">Log In</a>.</p>
    <?php else: ?>
        <p>Welcome back! Visit your <a href="dashboard.php">Dashboard</a> to manage your tasks.</p>
    <?php endif; ?>
</main>

<?php include 'components/footer.php'; ?>
