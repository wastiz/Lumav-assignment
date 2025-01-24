<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Data and Charts</title>
    <style>
        .chart {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .bar {
            width: 30px;
            background-color: #4CAF50;
            text-align: center;
            color: white;
            margin: 0 5px;
        }

        .pie-chart {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(#FF5733 0% 30%, #33FF57 30% 70%, #3357FF 70% 100%);
        }

        .pie-chart > .label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
        }
    </style>
</head>
<body>

<h1>Product Data and Charts</h1>

<button id="getCategories">Получить категории</button>
<button id="getPopularCategories">Получить популярные категории</button>
<button id="getProducts">Получить товары с главной страницы</button>

<div id="categoriesResult"></div>
<div id="popularCategoriesResult"></div>
<div id="productsResult"></div>

<h2>Charts</h2>

<div id="categoryChart" class="chart"></div>
<div id="priceRangeChart" class="chart"></div>
<div id="discountChart" class="chart"></div>

<script>
    // Получение категорий
    document.getElementById('getCategories').onclick = function() {
        fetch('get_categories.php')  // PHP-скрипт, который возвращает категории
            .then(response => response.json())
            .then(data => {
                document.getElementById('categoriesResult').innerHTML = JSON.stringify(data, null, 2);
                createCategoryChart(data.categories);
            })
            .catch(error => console.error('Error:', error));
    };

    document.getElementById('getPopularCategories').onclick = function() {
        fetch('get_popular_categories.php')  // PHP-скрипт для популярных категорий
            .then(response => response.json())
            .then(data => {
                document.getElementById('popularCategoriesResult').innerHTML = JSON.stringify(data, null, 2);
            })
            .catch(error => console.error('Error:', error));
    };

    document.getElementById('getProducts').onclick = function() {
        fetch('get_products.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('productsResult').innerHTML = JSON.stringify(data, null, 2);
                createPriceRangeChart(data.products);
                createDiscountChart(data.products);
            })
            .catch(error => console.error('Error:', error));
    };

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
        chartContainer.innerHTML = '';  // Очистка старого графика

        discounted.forEach(product => {
            const bar = document.createElement('div');
            bar.classList.add('bar');
            bar.style.height = `${product.discount * 10}px`;
            bar.innerHTML = `${product.title} - ${product.discount}%`;
            chartContainer.appendChild(bar);
        });
    }
</script>

</body>
</html>
