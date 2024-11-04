<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
</head>

<body>
    <h1>Your Shopping Cart</h1>
    <?php if (!empty($data['cartItems'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cartItems'] as $item): ?>
                    <tr>
                        
                    <td><?php echo htmlspecialchars($item->product_name); ?></td>
                    <td><?php echo htmlspecialchars($item->quantity); ?></td>
                        <td><?php echo htmlspecialchars($item->price); ?></td>
                        <td>
                        <a href="<?= URLROOT . "/cartController/increase/" . $item->product_id; ?>"><button>+</button></a>
                        <a href="<?= URLROOT . "/cartController/decrease/" . $item->product_id; ?>"><button>-</button></a>
                        <a href="<?= URLROOT . "/cartController/remove/" . $item->product_id; ?>"><button>x</button></a>
                </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total Items: <?php echo htmlspecialchars($data['totalItems']); ?></p>
        <p>Total Price: <?php echo htmlspecialchars($data['totalPrice']); ?></p>

        <!-- Buttons for navigation -->
        <a href="<?php echo URLROOT; ?>/productController" style="text-decoration: none;">
            <button>Back to Products</button>
        </a>
        <a href="<?php echo URLROOT; ?>/orderController/checkout" style="text-decoration: none;">
            <button>Proceed to Checkout</button>
        </a>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="<?php echo URLROOT; ?>/productController" style="text-decoration: none;">
            <button>Back to Products</button>
        </a>
    <?php endif; ?>
</body>
</html>

