<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/shopMVC2/public/css/style.css">
</head>

<?php require APPROOT . '/views/inc/header.php'; ?>

<body >
    <div class="container my-5">
        <h1 class="text-center mb-4 ">Your Orders</h1>

        <?php if (!empty($data['cartItems'])): ?>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item->product_name); ?></td>
                                <td><?php echo htmlspecialchars($item->cart_quantity); ?></td>
                                <td><?php echo "$" . number_format($item->price, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <p><strong>Total Items:<?php echo htmlspecialchars($data['totalItems']); ?></strong></p>
                    <p><strong>Total Price: $<?php echo number_format($data['totalPrice'], 2); ?></strong></p>
                </div>
            </div>

            <!-- Card for Address and Payment Form -->
            <div class="card p-4 shadow-lg mx-auto" style="max-width: 500px;">
                <h4 class="card-title text-center mb-4 text-primary">Shipping Address</h4>
                <form action="<?php echo URLROOT; ?>/orderController/payment" method="POST">
                    <div class="mb-3">
                        <label for="line1" class="form-label">Address Line 1</label>
                        <input type="text" id="line1" name="line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="line2" class="form-label">Address Line 2</label>
                        <input type="text" id="line2" name="line2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State/Province</label>
                        <input type="text" id="state" name="state" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="zip" class="form-label">Postal Code/Zip</label>
                        <input type="text" id="zip" name="zip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" id="country" name="country" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_method" class="form-label">Shipping Method</label>
                        <select id="shipping_method" name="shipping_method" class="form-select" required>
                            <option value="PayPal">PayPal</option>
                            <option value="Stripe">Stripe</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 ">Proceed to Payment</button>
                </form >
            </div>

            <div class="mt-3 text-center">
            <a href="<?= ($_SESSION['user_role'] === 'Admin') ? URLROOT . '/productController' : URLROOT ; ?>" class="btn btn-outline-secondary">
    Back To Products
</a> </div>

        <?php else: ?>
            <p class="text-center">Your orders are empty.</p>
            <div class="text-center">
                <a href="<?php echo URLROOT; ?>/productController" class="btn btn-outline-secondary">Back to Products</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional for extra interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
