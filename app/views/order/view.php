<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
</head>

<body>
    <h1>Your Orders</h1>
    <?php if (!empty($data['cartItems'])): ?>
        <table>
            <thead>
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
                    <td><?php echo htmlspecialchars($item->quantity); ?></td>
                        <td><?php echo htmlspecialchars($item->price); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total Items: <?php echo htmlspecialchars($data['totalItems']); ?></p>
        <p>Total Price: <?php echo htmlspecialchars($data['totalPrice']); ?></p>

        <form action="<?php echo URLROOT; ?>/orderController/payment" method="POST">
    <!-- Address fields -->
    <label for="line1">Address Line 1:</label>
    <input type="text" id="line1" name="line1" required>
<br>
    <label for="line2">Address Line 2:</label>
    <input type="text" id="line2" name="line2">
<br>
    <label for="city">City:</label>
    <input type="text" id="city" name="city" required>
<br>
    <label for="state">State/Province:</label>
    <input type="text" id="state" name="state" required>
<br>
    <label for="zip">Postal Code/Zip:</label>
    <input type="text" id="zip" name="zip" required>
<br>
    <label for="country">Country:</label>
    <input type="text" id="country" name="country" required>
<br>

<label for="shipping_method">Shipping Method:</label>
    <select id="shipping_method" name="shipping_method" required>
        <option value="PayPal">PayPal</option>
        <option value="Stripe">Stripe</option>
    </select>
<br>

    <!-- Single button for submission and payment redirection -->
    <button type="submit">
        Proceed to Payment
    </button>
</form>


        <!-- Buttons for navigation -->
        <a href="<?php echo URLROOT; ?>/productController" style="text-decoration: none;">
            <button>Back to Products</button>
        </a>
        </a>
    <?php else: ?>
        <p>Your orders is empty.</p>
        <a href="<?php echo URLROOT; ?>/productController" style="text-decoration: none;">
            <button>Back to Products</button>
        </a>
    <?php endif; ?>
</body>
</html>

