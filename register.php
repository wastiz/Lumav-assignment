<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="register-container">
    <h2>Регистрация</h2>

    <form method="POST" action="register.php">
        <div class="form-group">
            <input type="text" name="username" placeholder="Имя пользователя" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Пароль" required>
        </div>
        <div class="form-group">
            <button type="submit">Зарегистрироваться</button>
        </div>
    </form>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message">Ошибка: Пользователь с таким именем уже существует!</p>';
    }
    ?>
</div>

</body>
</html>
