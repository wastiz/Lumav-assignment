const categoryUrl = new URLSearchParams(window.location.search).get('category_url');

if (!categoryUrl) {
    console.error('URL is missing or invalid');
    document.getElementById('content-container').innerHTML = `<p>Category URL is missing or invalid</p>`;
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
                    document.getElementById('content-container').innerHTML = `<p>${products.error}</p>`;
                    return;
                }
                displayProducts(products)

                totalLoaded += products.length;
                currentPage++;
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                document.getElementById('content-container').innerHTML = `<p>Error fetching products</p>`;
            });
    }

    loadMoreProducts();
}