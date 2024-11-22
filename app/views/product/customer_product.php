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
    <div id="product-list" class="row">
    <?php foreach ($data['products'] as $product): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product">
            <img src="/shopMVC2/public/<?= htmlspecialchars($product->image_path) ?>" 
                 class="card-img-top mx-auto img-fluid" 
                 alt="<?= htmlspecialchars($product->name) ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                <p class="card-text">$<?= number_format($product->price, 2) ?></p>
                <a href="<?= URLROOT ?>/productController/show/<?= $product->id ?>" class="btn btn-danger w-100">View</a>

                <!-- Add to Cart Button -->
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
