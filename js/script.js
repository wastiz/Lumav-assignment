function fetchCategories() {
    fetch('get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('content-container').innerHTML = 'Error fetching categories';
            } else {
                allCategories = data;
                displayCategories(allCategories);
                getCategoriesCount(allCategories)
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
                getCategoriesCount(allCategories);
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
            allCategories = products
            displayProducts(products)
            createPriceRangeChart(products)
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            document.getElementById('content-container').innerHTML = `<p>Error fetching products</p>`;
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

function getCategoriesCount(categories) {
    const card = createChartCard("Category Count");

    const data = document.createElement('p');
    data.textContent = categories.length;

    card.appendChild(data);

    const chartContainer = document.getElementById('chart-container');
    chartContainer.innerHTML = ''
    chartContainer.appendChild(card);
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

    const chartContainer = document.getElementById('chart-container');
    chartContainer.innerHTML = ''
    const card = createChartCard("Price ranges")

    for (let range in priceRanges) {
        const bar = document.createElement('div');
        bar.classList.add('bar');
        bar.style.height = `${priceRanges[range] * 20}px`;
        bar.innerHTML = `${range}<br>${priceRanges[range]}`;
        card.appendChild(bar);
    }
    chartContainer.appendChild(card)
}

function createDiscountChart(products) {
    const discounted = products.filter(product => product.discount > 0);

    const chartContainer = document.getElementById('chart-container');

    discounted.forEach(product => {
        const bar = document.createElement('div');
        bar.classList.add('bar');
        bar.style.height = `${product.discount * 10}px`;
        bar.innerHTML = `${product.title} - ${product.discount}%`;
        chartContainer.appendChild(bar);
    });
}

function createChartCard(name) {
    const card = document.createElement('div');
    card.classList.add('chart-card');

    const title = document.createElement('h3');
    title.textContent = name;
    card.appendChild(title);

    return card;
}

