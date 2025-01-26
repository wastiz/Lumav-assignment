function fetchCategories() {
    fetch('get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('content-container').innerHTML = 'Error fetching categories';
            } else {
                allCategories = data;
                displayCategories(allCategories);
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
}

function fetchPopularCategories(){
    fetch('get_popular_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('content-container').innerHTML = 'Error fetching categories';
            } else {
                allCategories = data;
                displayCategories(allCategories);
            }
        })
        .catch(error => console.error('Error:', error));
}

function fetchProductsFrontPage () {
    fetch(`get_products_frontpage.php`)
        .then(response => response.json())
        .then(products => {
            if (products.error) {
                console.error('Error:', products.error);
                document.getElementById('content-container').innerHTML = `<p>${products.error}</p>`;
                return;
            }
            displayProducts(products)
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            document.getElementById('content-container').innerHTML = `<p>Error fetching products</p>`;
        });
}

function createCategoryChart(categories) {
    const totalProducts = categories.reduce((sum, category) => sum + category.count, 0);
    const chartContainer = document.getElementById('categoryChart');
    chartContainer.innerHTML = '';  // Очистка старого графика

    categories.forEach(category => {
        const percentage = (category.count / totalProducts) * 100;
        const pieSlice = document.createElement('div');
        pieSlice.classList.add('pie-chart');
        pieSlice.innerHTML = `<div class="label">${category.name} - ${category.count}</div>`;
        chartContainer.appendChild(pieSlice);
    });
}

function createPriceRangeChart(products) {
    const priceRanges = { '0-100': 0, '100-500': 0, '500-1000': 0, '1000+': 0 };

    products.forEach(product => {
        const price = parseFloat(product.price.replace('€', '').replace(',', '.'));
        if (price <= 100) priceRanges['0-100']++;
        else if (price <= 500) priceRanges['100-500']++;
        else if (price <= 1000) priceRanges['500-1000']++;
        else priceRanges['1000+']++;
    });

    const chartContainer = document.getElementById('priceRangeChart');
    chartContainer.innerHTML = '';

    for (let range in priceRanges) {
        const bar = document.createElement('div');
        bar.classList.add('bar');
        bar.style.height = `${priceRanges[range] * 20}px`;
        bar.innerHTML = `${range}<br>${priceRanges[range]}`;
        chartContainer.appendChild(bar);
    }
}

function createDiscountChart(products) {
    const discounted = products.filter(product => product.discount > 0);

    const chartContainer = document.getElementById('discountChart');
    chartContainer.innerHTML = '';

    discounted.forEach(product => {
        const bar = document.createElement('div');
        bar.classList.add('bar');
        bar.style.height = `${product.discount * 10}px`;
        bar.innerHTML = `${product.title} - ${product.discount}%`;
        chartContainer.appendChild(bar);
    });
}

function displayCategories(categories) {
    let categoriesDiv = document.getElementById('content-container');
    categoriesDiv.innerHTML = '';

    categories.forEach(category => {
        const categoryDiv = document.createElement('div');
        categoryDiv.classList.add("category-block");
        categoryDiv.innerHTML = `<a href="products.php?category_url=${encodeURIComponent(category.url)}" target="_blank">${category.name}</a>`;
        categoriesDiv.appendChild(categoryDiv);
    });
}

function displayProducts(products){
    const productContainer = document.getElementById('content-container');
    productContainer.innerHTML = '';

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
}

function filterCategories() {
    const query = document.getElementById('search-bar').value.toLowerCase();
    const filteredCategories = allCategories.filter(category =>
        category.name.toLowerCase().includes(query)
    );
    displayCategories(filteredCategories);
}