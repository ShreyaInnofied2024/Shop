
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center">Order #<?= htmlspecialchars($data['orderInfo']->order_id) ?> Details</h1>

    <div class="card mt-3">
        <div class="card-header">
            <strong>Order Info</strong>
        </div>
        <div class="card-body">
            <p><strong>Status: <?= htmlspecialchars($data['orderInfo']->status) ?></strong></p>
            <p><strong> On: <?= htmlspecialchars($data['orderInfo']->created_at) ?></strong></p>
            <p><strong> Amount: $<?= number_format($data['orderInfo']->total_amount, 2) ?></strong></p>
            <p><strong> Method: <?= htmlspecialchars($data['orderInfo']->shipping_method) ?></strong></p>
        </div>
    </div>

    <div class="mt-4">
        <h2>Products in Order</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['orderItems'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->product_name) ?></td>
                        <td><?= htmlspecialchars($item->quantity) ?></td>
                        <td>$<?= number_format($item->price, 2) ?></td>
                        <td>$<?= number_format($item->total_price, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-bottom:50px;" class="text-center">
            <a  href="<?= URLROOT ?>/orderController/history" class="btn btn-secondary">Back to History</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
