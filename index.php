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
    <title>Product Data and Charts</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<main>
    <h1 class="mb-20">Lumav Assignment. Product Data and Charts</h1>

    <div class="d-flex flex-row flex-center gap-5 mb-20">
        <button id="getCategories" class="btn" onclick="fetchCategories()">Get Categories</button>
        <button id="getPopularCategories" class="btn" onclick="fetchPopularCategories()">Get Popular Categories</button>
        <button id="getProducts" class="btn" onclick="fetchProductsFrontPage()">Get Front Page Products</button>
    </div>

    <div class="d-flex flex-center mb-20">
        <input type="text" id="search-bar" placeholder="Search categories..." oninput="filterCategories()" />
    </div>

    <h2>Charts</h2>

    <div id="categoryChart" class="chart"></div>
    <div id="priceRangeChart" class="chart"></div>
    <div id="discountChart" class="chart"></div>

    <div id="content-container"></div>
</main>

<script src="js/index.js"></script>
<script src="js/script.js"></script>

</body>
</html>
