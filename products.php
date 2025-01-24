<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Products in Category</h2>
<a href="home.php">
    <button class="btn">Back</button>
</a>
<div id="product-container" class="product-grid"></div>
<button class="btn" onclick="loadMoreProducts()">Load More</button>

<script>
    const categoryUrl = new URLSearchParams(window.location.search).get('category_url');

    if (!categoryUrl) {
        console.error('URL is missing or invalid');
        document.getElementById('product-container').innerHTML = `<p>Category URL is missing or invalid</p>`;
    } else {
        console.log('Category URL:', categoryUrl);

        let currentPage = 1;
        let totalLoaded = 0;

        function loadMoreProducts() {
            fetch(`get_products.php?url=${encodeURIComponent(categoryUrl)}&p=${currentPage}`)
                .then(response => response.json())
                .then(products => {
                    if (products.error) {
                        console.error('Error:', products.error);
                        document.getElementById('product-container').innerHTML = `<p>${products.error}</p>`;
                        return;
                    }

                    const productContainer = document.getElementById('product-container');
                    products.forEach(product => {
                        const productDiv = document.createElement('div');
                        productDiv.classList.add('product-card');
                        productDiv.innerHTML = `
                            <img src="${product.img}" alt="${product.title}" class="product-img">
                            <a href="${product.url}" target="_blank" class="product-title">${product.title}</a>
                            <p class="product-price">${product.price}</p>
                        `;
                        productContainer.appendChild(productDiv);
                    });

                    totalLoaded += products.length;
                    currentPage++;

                    if (products.length === 0 || totalLoaded >= 100) {
                        document.getElementById('load-more').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    document.getElementById('product-container').innerHTML = `<p>Error fetching products</p>`;
                });
        }

        loadMoreProducts();
    }
</script>

</body>
</html>
