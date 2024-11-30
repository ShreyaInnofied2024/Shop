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
<style>
    /* Custom styles for static price summary and accordion */
    .static-summary {
        position: sticky;
        top: 0;
        background: #fff;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .cart-summary {
        margin-top: 20px;
    }

    .custom-btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 30px;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #28a745;
        transform: translateY(-2px);
    }

    .custom-btn:disabled {
        background-color: #d6d6d6;
        cursor: not-allowed;
    }
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

    .custom-btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 30px;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #28a745;
        transform: translateY(-2px);
    }

    .custom-btn:disabled {
        background-color: #d6d6d6;
        cursor: not-allowed;
    }

    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

.payment-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.payment-timer {
    font-size: 16px;
    color: #ff5722;
    text-align: center;
    margin-bottom: 20px;
}

.payment-methods .payment-option {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.payment-methods label {
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
}

.payment-methods .sub-options {
    margin-left: 20px;
    display: none;
}

.payment-methods input[type="radio"]:checked + label + .sub-options {
    display: block;
}

.price-details {
    border-top: 1px solid #ddd;
    margin-top: 20px;
    padding-top: 10px;
}

.price-details p, .price-details h4 {
    margin: 10px 0;
    font-size: 14px;
}

.price-details h4 {
    font-size: 18px;
    color: #333;
}
</style>

<?php require APPROOT . '/views/inc/header.php'; ?>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Your Orders</h1>

        <?php if (!empty($data['cartItems'])): ?>
        <div class="row">
            

            <!-- Accordion for Order Summary, Delivery Address, Payment Method -->
            <div class="col-md-8">
                <div class="accordion" id="orderAccordion">
                    <!-- Order Summary -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#orderSummary" aria-expanded="false" aria-controls="orderSummary">
                                <strong>Order Summary</strong>
                            </button>
                        </h2>
                        <div id="orderSummary" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                <?php foreach ($data['cartItems'] as $item): ?>
                                    <div class="cart-item">
                                        <img src="/shopMVC2/public/<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->product_name) ?>" class="img-fluid">
                                        <div class="cart-item-details">
                                            <h5><?= htmlspecialchars($item->product_name) ?></h5>
                                            <p class="text-muted"><?= htmlspecialchars($item->product_description) ?></p>
                                            <p>
                                                <span class="text-muted text-decoration-line-through">Rs <?= number_format($item->original_price, 2) ?></span>
                                                <span class="text-success">Rs <?= number_format($item->price, 2) ?></span>
                                                <span class="text-danger">(<?= htmlspecialchars($item->discount) ?>% off)</span>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#deliveryAddress" aria-expanded="false" aria-controls="deliveryAddress">
                                <strong>Delivery Address</strong>
                            </button>
                        </h2>
                        <div id="deliveryAddress" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                            <?php foreach ($data['addresses'] as $addresses): ?>
                                <div class="cart-item d-flex justify-content-between align-items-center">
    <!-- Address Text -->
    <p class="mb-0">
        <span class="text-primary"><?= $addresses->address ?></span>
    </p>

    <!-- Buttons (Edit and Delete) -->
    <div class="d-flex"><button type="button" class="btn btn-outline-primary btn-sm me-2 edit-address-btn" 
        data-id="<?= $addresses->id ?>" 
        data-line1="<?= htmlspecialchars($addresses->line1) ?>" 
        data-line2="<?= htmlspecialchars($addresses->line2) ?>" 
        data-city="<?= htmlspecialchars($addresses->city) ?>" 
        data-state="<?= htmlspecialchars($addresses->state) ?>" 
        data-zip="<?= htmlspecialchars($addresses->zip) ?>" 
        data-country="<?= htmlspecialchars($addresses->country) ?>" 
        data-bs-toggle="modal" data-bs-target="#editAddressModal">
    Edit
</button>

        <form method="POST" action="<?= URLROOT; ?>/userController/deleteAddress">
            <input type="hidden" name="address_id" value="<?= $addresses->id ?>">
            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
        </form>
    </div>
</div>

                                <?php endforeach; ?>
                            
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary custom-btn" data-bs-toggle="modal" data-bs-target="#addressModal">
                                        Add Address
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paymentMethod" aria-expanded="false" aria-controls="paymentMethod">
                                <strong>Payment Method</strong>
                            </button>
                        </h2>
                        <div id="paymentMethod" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                <!-- Payment Method Options -->
                                <div class="payment-container">
                                    <div class="payment-timer">
                                        Complete payment in <span id="timer">00:13:27</span>
                                    </div>
                                    <div class="payment-methods">
                <!-- UPI Option -->
                <div class="payment-option">
                    <input type="radio" id="upi" name="payment" />
                    <label for="upi">UPI</label>
                    <div class="sub-options">
                        <input type="radio" id="phonepe" name="upi-option">
                        <label for="phonepe">PhonePe</label><br>
                        <input type="radio" id="upi-id" name="upi-option">
                        <label for="upi-id">Google Pay</label>
                    </div>
                </div>

                <!-- Wallets Option -->
                <div class="payment-option">
                    <input type="radio" id="wallets" name="payment" />
                    <label for="wallets">PayPal</label>
                </div>

                <!-- Credit/Debit Cards Option -->
                <div class="payment-option">
                    <input type="radio" id="cards" name="payment" />
                    <label for="cards">Stripe</label>
                </div>

                <!-- Net Banking Option -->
                <div class="payment-option">
                    <input type="radio" id="netbanking" name="payment" />
                    <label for="netbanking">Net Banking</label>
                </div>

                <!-- Cash on Delivery Option -->
                <div class="payment-option">
                    <input type="radio" id="cod" name="payment" />
                    <label for="cod">Cash on Delivery</label>
                </div>
            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>


                <div class="col-md-4 static-summary">
                <div class="cart-summary ">
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
            </div>

                <!-- Proceed to Payment Button -->
                <div class="text-center mt-4">
                    <a href="<?php echo URLROOT; ?>/orderController/payment" id="proceed-button" class="btn btn-success custom-btn" id="proceed-link" disabled>Proceed to Payment</a>
                </div>
            </div>
        </div>

        <!-- Address Modal -->
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addressModalLabel">Add Shipping Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="address-form" action="<?php echo URLROOT; ?>/userController/addAddress" method="POST">
    <div class="modal-body">
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
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Address</button>
    </div>
</form>

                </div>
            </div>
        </div>


        <!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Shipping Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-address-form" action="<?php echo URLROOT; ?>/userController/editAddress" method="POST">
                <div class="modal-body">
                    <!-- Hidden field for Address ID -->
                    <input type="hidden" id="edit-address-id" name="address_id">

                    <div class="mb-3">
                        <label for="edit-line1" class="form-label">Address Line 1</label>
                        <input type="text" id="edit-line1" name="line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-line2" class="form-label">Address Line 2</label>
                        <input type="text" id="edit-line2" name="line2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit-city" class="form-label">City</label>
                        <input type="text" id="edit-city" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-state" class="form-label">State/Province</label>
                        <input type="text" id="edit-state" name="state" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-zip" class="form-label">Postal Code/Zip</label>
                        <input type="text" id="edit-zip" name="zip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-country" class="form-label">Country</label>
                        <input type="text" id="edit-country" name="country" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Address</button>
                </div>
            </form>
        </div>
    </div>
</div>


        <?php else: ?>
        <p class="text-center">Your orders are empty.</p>
        <div class="text-center">
            <a href="<?php echo URLROOT; ?>/productController" class="btn btn-outline-secondary">Back to Products</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById("addressForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    fetch("<?php echo URLROOT; ?>/UserController/addAddress", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Address saved successfully!");
                location.reload(); // Reload the page or update the UI dynamically
            } else {
                alert("Failed to save address. Please try again.");
            }
        })
        .catch((error) => console.error("Error:", error));
});

document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-address-btn');
    const editModal = document.getElementById('editAddressModal');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit-address-id').value = this.getAttribute('data-id');
            document.getElementById('edit-line1').value = this.getAttribute('data-line1');
            document.getElementById('edit-line2').value = this.getAttribute('data-line2');
            document.getElementById('edit-city').value = this.getAttribute('data-city');
            document.getElementById('edit-state').value = this.getAttribute('data-state');
            document.getElementById('edit-zip').value = this.getAttribute('data-zip');
            document.getElementById('edit-country').value = this.getAttribute('data-country');
        });
    });
});




    </script>
</body>
</html>
