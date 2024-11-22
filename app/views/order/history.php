
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .order-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .order-body {
            padding: 15px;
        }
        .product-list img {
            max-width: 50px;
            margin-right: 10px;
        }
        .order-total {
            font-weight: bold;
        }
    </style>
</head>
<body>
          
       
<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Order History</h1>
    <a style="margin-bottom:20px;" href="<?= URLROOT ?>" class="btn btn-secondary">Back to Shop</a>

    <?php if (!empty($data['orders'])): ?>
        <?php foreach ($data['orders'] as $order): ?>
            <div class="card mb-3 order-card">
                <div class="order-header">
                    <div class="d-flex justify-content-between">
                        <span>Order #<?= htmlspecialchars($order->id) ?></span>
                        <span>Status: <strong><?= htmlspecialchars($order->status) ?></strong></span>
                    </div>
                    <small>Placed on <?= htmlspecialchars($order->created_at) ?></small>
                </div>
                <div class="order-body">
                    <p class="order-total">Total: $<?= number_format($order->total_amount, 2) ?></p>
                    <p>Shipping Method: <?= htmlspecialchars($order->shipping_method) ?></p>
                    <a href="<?= URLROOT ?>/orderController/details/<?= $order->id ?>" class="btn btn-primary">
                        View Details
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
        You have no orders yet.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
