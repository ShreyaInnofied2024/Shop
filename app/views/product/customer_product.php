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
    <style>
        .card {
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            border-radius: 10px;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 500;
        }

        .text-truncate {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-body {
    display: flex;
    flex-direction: column;
    height: 100%; /* Ensures the card body takes full height */
}

.card-body .mt-auto {
    margin-top: auto; /* Pushes the button to the bottom of the card */
}

.card-title {
    margin-bottom: auto; /* Optional: Aligns the title with other elements */
}

    </style>
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
                        <?php foreach ($data['categories'] as $category) : ?>
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

        <div class="container mt-4">
    <div id="product-list" class="row">
        <?php foreach ($data['products'] as $product) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="<?= URLROOT ?>/productController/show/<?= $product->id ?>" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0">
                        <!-- Product Image -->
                        <img src="/shopMVC2/public/<?= htmlspecialchars($product->image_path) ?>" class="card-img-top img-fluid p-3 rounded" alt="<?= htmlspecialchars($product->name) ?>" style="height: 200px; object-fit: cover;">

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column justify-content-between text-center">
                            <!-- Product Name -->
                            <h6 class="card-title text-truncate"><?= htmlspecialchars($product->name) ?></h6>

                            <!-- Price -->
                            <p class="text-muted mb-1">Rs <?= number_format($product->price, 2) ?></p>

                            <!-- Stock Logic -->
                            <div class="mt-auto">
                                <?php if ($product->quantity > 0): ?>
                                    <p class="text-success small"><?= $product->stock_message ?></p>
                                    <a href="<?= URLROOT ?>/cartController/add/<?= $product->id ?>"
                                       class="btn btn-primary btn-sm w-100">Add to Cart</a>
                                <?php else: ?>
                                    <p class="text-danger small"><?= $product->stock_message ?></p>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Notify Me</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
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
    const productStockMessage = product.stock_message || ''; // Fallback to empty string if undefined or null

    const productDiv = `
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <a href="${'<?= URLROOT ?>'}/productController/show/${product.id}" class="text-decoration-none text-dark">
            <div class="card shadow-sm border-0">
                <!-- Product Image -->
                <img src="/shopMVC2/public/${product.image_path}" class="card-img-top img-fluid p-3 rounded" alt="${product.name}" style="height: 200px; object-fit: cover;">

                <!-- Card Body -->
                <div class="card-body d-flex flex-column justify-content-between text-center">
                    <!-- Product Name -->
                    <h6 class="card-title text-truncate">${product.name}</h6>

                    <!-- Price -->
                    <p class="text-muted mb-1">Rs ${product.price.toFixed(2)}</p>

                    <!-- Stock Logic -->
                    <div class="mt-auto">
                        ${product.quantity > 0 
                            ? `<p class="text-success small">${productStockMessage}</p>
                               <a href="${'<?= URLROOT ?>'}/cartController/add/${product.id}" class="btn btn-primary btn-sm w-100">Add to Cart</a>`
                            : `<p class="text-danger small">${productStockMessage}</p>
                               <button class="btn btn-secondary btn-sm w-100" disabled>Notify Me</button>`}
                    </div>
                </div>
            </div>
        </a>
    </div>`;

    productList.insertAdjacentHTML('beforeend', productDiv);
});


        }

        // Function to clear all filters
        function clearFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('category-select').value = '';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            filterProducts();
        }
    </script>
</body>

</html>