<?php

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Welcome to Home Page</h2>
<p>Here you can see the categories fetched from the site:</p>

<input type="text" id="search-bar" placeholder="Search categories..." oninput="filterCategories()" />

<div id="category-container"></div>

<script src="script.js"></script>
<script>fetchCategories();</script>

</body>
</html>
