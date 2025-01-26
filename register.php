<?php
$db = new PDO('sqlite:app.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header('Location: register.php?error=username_taken');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<main class="w-100 h-100 d-flex flex-col flex-center">
    <div class="login-container">
        <h2>Register</h2>

        <form method="POST" action="register.php" class="d-flex flex-col flex-center">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <a href="login.php" class="mb-20">Already have an account? Log in</a>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'username_taken') {
            echo '<p class="error-message">Error: User with this name already exists. Please choose a different username.</p>';
        }
        ?>
    </div>
</main>

</body>
</html>
