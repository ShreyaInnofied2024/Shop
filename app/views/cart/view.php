<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Shopping Cart</h1>

        <!-- Display message if cart is empty -->
        <?php if (!empty($data['cartItems'])): ?>
            <div class="row">
                <?php foreach ($data['cartItems'] as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="/shopMVC2/public/<?= htmlspecialchars($item->image_path) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($item->product_name) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item->product_name) ?></h5>
                                
                               
                            </div>
                            <p class="card-text text-center">Price: Rs <?= number_format($item->price, 2) ?></p>
                            <p class="card-text text-center">Quantity: <?= htmlspecialchars($item->cart_quantity) ?></p>

                            <div class="d-flex justify-content-between">
                                    <a href="<?= URLROOT . "/cartController/increase/" . $item->product_id; ?>" class="btn btn-outline-primary" style="margin-right: 5px;">+</a>
                                    <a href="<?= URLROOT . "/cartController/decrease/" . $item->product_id; ?>" class="btn btn-outline-warning"  style="margin-right: 5px;">-</a>
                                    <a href="<?= URLROOT . "/cartController/remove/" . $item->product_id; ?>" class="btn btn-outline-danger">Remove</a>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="d-flex justify-content-between">
                <p><strong>Total Items: <?= htmlspecialchars($data['totalItems']); ?></strong></p>
                <p><strong> Price: Rs <?= number_format($data['totalPrice'], 2); ?></strong></p>
            </div>

            <!-- Buttons for navigation -->
            <div class="d-flex justify-content-between mt-4" style="margin-bottom: 100px;">
            <a href="<?= ($_SESSION['user_role'] === 'Admin') ? URLROOT . '/productController' : URLROOT . '/home'; ?>" class="btn btn-outline-secondary">
    Back To Products
</a>
<a href="<?= URLROOT; ?>/orderController/checkout" class="btn btn-success">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Your cart is empty.
            </div>
            <a href="<?= ($_SESSION['user_role'] === 'Admin') ? URLROOT . '/productController' : URLROOT ; ?>" class="btn btn-outline-secondary">
    Back To Products
</a>



             <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
