<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .cart-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item img {
            width: 150px;
            height: auto;
            border-radius: 8px;
        }

        .cart-item-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        .cart-item-details h5 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .cart-item-details p {
            margin: 0;
        }

        .cart-item-details .text-success {
            font-weight: bold;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .cart-item-actions .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .cart-item-actions .quantity-controls span {
            min-width: 30px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .cart-summary {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: sticky;
            top: 20px;
        }

        .cart-summary h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .cart-summary p {
            margin: 0;
        }

        .cart-summary .total {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .cart-summary .text-success {
            font-size: 14px;
            font-weight: bold;
        }

        .btn-lg {
            padding: 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Your Shopping Cart</h1>

    <?php if (!empty($data['cartItems'])): ?>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-md-8">
                <?php foreach ($data['cartItems'] as $item): ?>
                    <div class="cart-item">
                        <img src="/shopMVC2/public/<?= htmlspecialchars($item->image_path) ?>" 
                             alt="<?= htmlspecialchars($item->product_name) ?>" class="img-fluid">
                        <div class="cart-item-details">
                            <h5><?= htmlspecialchars($item->product_name) ?></h5>
                            <p class="text-muted"><?= htmlspecialchars($item->product_description) ?></p>
                            <p>
                                <span class="text-muted text-decoration-line-through">Rs <?= number_format($item->original_price, 2) ?></span>
                                <span class="text-success">Rs <?= number_format($item->price, 2) ?></span>
                                <span class="text-danger">(<?= htmlspecialchars($item->discount) ?>% off)</span>
                            </p>
                        </div>
                        <div class="cart-item-actions">
                            <div class="quantity-controls">
                                <a href="<?= URLROOT . "/cartController/decrease/" . $item->product_id; ?>" 
                                   class="btn btn-outline-warning btn-sm">-</a>
                                <span><?= htmlspecialchars($item->cart_quantity) ?></span>
                                <a href="<?= URLROOT . "/cartController/increase/" . $item->product_id; ?>" 
                                   class="btn btn-outline-primary btn-sm">+</a>
                            </div>
                            <a href="<?= URLROOT . "/cartController/remove/" . $item->product_id; ?>" 
                               class="btn btn-outline-danger btn-sm">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary -->
            <div class="col-md-4">
                <div class="cart-summary">
                    <h5>PRICE DETAILS</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p>Price (<?= htmlspecialchars($data['totalItems']); ?> items)</p>
                        <p>Rs <?= number_format($data['totalPrice'], 2); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Discount</p>
                        <p class="text-success">- Rs <?= number_format($data['totalDiscount'], 2); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Delivery Charges</p>
                        <p class="text-success">Free</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Amount</strong>
                        <strong class="total">Rs <?= number_format($data['finalAmount'], 2); ?></strong>
                    </div>
                    <p class="text-success mt-2">You will save Rs <?= number_format($data['totalDiscount'], 2); ?> on this order</p>
                </div>
                <a href="<?= URLROOT; ?>/orderController/checkout" class="btn btn-success btn-lg w-100 mt-3">Place Order</a>
            </div>
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
