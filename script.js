let allCategories = [];

function fetchCategories() {
    fetch('get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('category-container').innerHTML = 'Error fetching categories';
            } else {
                allCategories = data;
                displayCategories(allCategories);
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
}

function displayCategories(categories) {
    let categoriesDiv = document.getElementById('category-container');
    categoriesDiv.innerHTML = '';

    categories.forEach(category => {
        const categoryDiv = document.createElement('div');
        categoryDiv.classList.add("category-block");
        categoryDiv.innerHTML = `<a href="products.php?category_url=${encodeURIComponent(category.url)}" target="_blank">${category.name}</a>`;
        categoriesDiv.appendChild(categoryDiv);
    });
}

function filterCategories() {
    const query = document.getElementById('search-bar').value.toLowerCase();
    const filteredCategories = allCategories.filter(category =>
        category.name.toLowerCase().includes(query)
    );
    displayCategories(filteredCategories);
}