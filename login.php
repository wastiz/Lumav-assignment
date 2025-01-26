<?php
session_start();

try {
    $db = new PDO('sqlite:app.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
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

<main class="w-100 h-100 d-flex flex-col flex-center">
    <div class="login-container">
        <h2>Please login to continue</h2>

        <form method="POST" action="login.php" class="d-flex flex-col flex-center">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <a href="register.php" class="mb-20">Don't have an account? Register one here</a>
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
</main>

</body>
</html>
