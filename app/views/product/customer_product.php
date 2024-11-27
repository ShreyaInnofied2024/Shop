<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="/shopMVC2/public/css/style.css">
   <script src="index.js"></script>
   <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
   <script src="<?php echo URLROOT ?>/public/js/pagination.js"></script>
  
</head>
<body>
<div id="product" class="container mb-5">
    <h2 class="text-center mb-4">Shop Our Products</h2>
    <div id="product-filter" class="mb-5">
    <div class="row justify-content-center">
        <!-- Search Input -->
        <div class="col-md-3 col-sm-6 mb-3 mb-sm-0">
            <input type="text" id="search-input" class="form-control form-control-lg" placeholder="Search for products" oninput="filterProducts()">
        </div>

        <!-- Category Filter (Optional) -->
        <div class="col-md-3 col-sm-6 mb-3 mb-sm-0">
            <select id="category-select" class="form-control form-control-lg" onchange="filterProducts()">
                <option value="">Select Category</option>
                <?php foreach ($data['categories'] as $category): ?>
                    <option value="<?php echo $category->id; ?>">
                            <?php echo $category->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Price Range Filter -->
        <div class="col-md-2 col-sm-6 mb-3 mb-sm-0">
            <input type="number" id="min-price" class="form-control form-control-lg" placeholder="Min Price" oninput="filterProducts()">
        </div>
        <div class="col-md-2 col-sm-6 mb-3 mb-sm-0">
            <input type="number" id="max-price" class="form-control form-control-lg" placeholder="Max Price" oninput="filterProducts()">
        </div>

        <!-- Clear Filter Button -->
        <div class="col-md-2 col-sm-6 mb-3 mb-sm-0">
            <button id="clear-filters" class="btn btn-lg btn-outline-danger w-100" onclick="clearFilters()">Clear Filters</button>
        </div>
    </div>
</div>




<div id="product-list" class="row">
    <?php foreach ($data['products'] as $product): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product" 
         data-category="<?= $product->category_id ?>" 
         data-name="<?= htmlspecialchars(strtolower($product->name)) ?>"
         data-price="<?= $product->price ?>">
        <div class="card product">
            <img src="/shopMVC2/public/<?= htmlspecialchars($product->image_path) ?>" 
                 class="card-img-top mx-auto img-fluid" 
                 alt="<?= htmlspecialchars($product->name) ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                <p class="card-text">$<?= number_format($product->price, 2) ?></p>
                <a href="<?= URLROOT ?>/productController/show/<?= $product->id ?>" class="btn btn-danger w-100">View</a>
                <a href="<?= URLROOT ?>/cartController/add/<?= $product->id ?>" class="btn btn-primary w-100 mt-2">Add to Cart</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


   

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                <li class="page-item">
                    <button class="page-link pagination-btn" data-page="<?= $i ?>"><?= $i ?></button>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script>
    // Global variables
let products = <?php echo json_encode($data['products']); ?>;

// Function to filter products
function filterProducts() {
    const searchQuery = document.getElementById('search-input').value.toLowerCase();
    const selectedCategory = parseInt(document.getElementById('category-select').value) || 0;
    const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
    const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

    // Filter products based on the criteria
    const filteredProducts = products.filter(product => {
        const productName = product.name.toLowerCase();
        const productCategory = product.category_id;
        const productPrice = product.price;

        const matchesSearch = productName.includes(searchQuery);
        const matchesCategory = selectedCategory ? productCategory === selectedCategory : true;
        const matchesPrice = productPrice >= minPrice && productPrice <= maxPrice;

        return matchesSearch && matchesCategory && matchesPrice;
    });

    // Show products based on the filter
    displayProducts(filteredProducts);
}

// Function to display filtered products
function displayProducts(filteredProducts) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // Clear the existing products

    filteredProducts.forEach(product => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('col-lg-3', 'col-md-4', 'col-sm-6', 'mb-4', 'product');

        productDiv.innerHTML = `
            <div class="card product">
                <img src="/shopMVC2/public/${product.image_path}" class="card-img-top mx-auto img-fluid" alt="${product.name}">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">$${product.price.toFixed(2)}</p>
                    <a href="<?= URLROOT ?>/productController/show/${product.id}" class="btn btn-danger w-100">View</a>
                    <a href="<?= URLROOT ?>/cartController/add/${product.id}" class="btn btn-primary w-100 mt-2">Add to Cart</a>
                </div>
            </div>
        `;

        productList.appendChild(productDiv);
    });
}

// Function to clear all filters
function clearFilters() {
    // Reset the search input, category select, and price inputs
    document.getElementById('search-input').value = '';
    document.getElementById('category-select').value = '';
    document.getElementById('min-price').value = '';
    document.getElementById('max-price').value = '';

    // Call filterProducts to display all products again
    filterProducts();
}


</script>



