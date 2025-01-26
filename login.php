<?php
session_start();

$correct_username = "user";
$correct_password = "password";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['logged_in'] = true;
        header('Location: home.php');
        exit();
    } else {
        header('Location: login.php?error=true');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Please login to continue</h2>

    <form method="POST" action="login.php">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <a href="register.php">Don't have an account? Register one here</a>
        <div class="form-group">
            <button type="submit">Log in</button>
        </div>
    </form>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message">Incorrect username or password!</p>';
    }
    ?>
</div>

</body>
</html>
