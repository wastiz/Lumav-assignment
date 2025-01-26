<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Products in Category</h2>
<div class="d-flex flex-center mb-20 gap-5">
    <a href="index.php">
        <button class="btn">Back</button>
    </a>
    <button id="load-more" class="btn" onclick="loadMoreProducts()">Load Next Page</button>
</div>
<div id="content-container"></div>

<script src="js/products.js"></script>
<script src="js/script.js"></script>

</body>
</html>
