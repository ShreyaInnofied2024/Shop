<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- Bootstrap JS (after Bootstrap CSS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    <?php
    $addressParts = explode(',', $addresses->address);
    ?>
    <div class="cart-item d-flex justify-content-between align-items-center">
        <p class="mb-0"><span class="text-primary"><?= $addresses->address ?></span></p>

        <div class="d-flex align-items-center">
        <form method="POST" id="addressForm" class="mb-0">
            <input type="hidden" id="selected_address_id" name="selected_address_id" value="<?= $addresses->id ?>">
            <button class="btn btn-outline-success btn-sm select-address-btn" type="button" data-address-id="<?= $addresses->id ?>">Select</button>
        </form>
    <button type="button" class="btn btn-outline-primary btn-sm me-2 edit-address-btn" 
        data-id="<?= $addresses->id ?>" 
        data-line1="<?= isset($addressParts[0]) ? trim($addressParts[0]) : '' ?>" 
        data-line2="<?= isset($addressParts[1]) ? trim($addressParts[1]) : '' ?>" 
        data-city="<?= isset($addressParts[2]) ? trim($addressParts[2]) : '' ?>" 
        data-state="<?= isset($addressParts[3]) ? trim($addressParts[3]) : '' ?>" 
        data-zip="<?= isset($addressParts[4]) ? trim($addressParts[4]) : '' ?>" 
        data-country="<?= isset($addressParts[5]) ? trim($addressParts[5]) : '' ?>" 
        data-bs-toggle="modal" data-bs-target="#editAddressModal">
        Edit
    </button>

    <form method="POST" action="<?= URLROOT; ?>/userController/deleteAddress" class="mb-0">
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
                                <div class="payment-methods">
                                    <div class="payment-option">
                                        <input type="radio" id="upi" name="payment" value="UPI" />
                                        <label for="upi">UPI</label>
                                    </div>

                                    <div class="payment-option">
                                        <input type="radio" id="paypal" name="payment" value="PayPal" />
                                        <label for="paypal">PayPal</label>
                                    </div>

                                    <div class="payment-option">
                                        <input type="radio" id="stripe" name="payment" value="Stripe" />
                                        <label for="stripe">Stripe</label>
                                    </div>

                                    <div class="payment-option">
                                        <input type="radio" id="cod" name="payment" value="COD" />
                                        <label for="cod">Cash on Delivery</label>
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
                <button type="button" id="proceed-to-payment" class="btn btn-success custom-btn" disabled>Proceed to Payment</button>
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

        <!-- Edit Address Modal -->
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
                    <input type="hidden" id="editAddressId" name="id">
                    <div class="mb-3">
                        <label for="editLine1" class="form-label">Address Line 1</label>
                        <input type="text" id="editLine1" name="line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLine2" class="form-label">Address Line 2</label>
                        <input type="text" id="editLine2" name="line2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editCity" class="form-label">City</label>
                        <input type="text" id="editCity" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editState" class="form-label">State/Province</label>
                        <input type="text" id="editState" name="state" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editZip" class="form-label">Postal Code/Zip</label>
                        <input type="text" id="editZip" name="zip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCountry" class="form-label">Country</label>
                        <input type="text" id="editCountry" name="country" class="form-control" required>
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
        

    // Add jQuery to fill the modal inputs when "Edit" button is clicked
    $(document).on('click', '.edit-address-btn', function () {
        var addressId = $(this).data('id');
        var line1 = $(this).data('line1');
        var line2 = $(this).data('line2');
        var city = $(this).data('city');
        var state = $(this).data('state');
        var zip = $(this).data('zip');
        var country = $(this).data('country');

        // Set values in the modal
        $('#editAddressId').val(addressId);
        $('#editLine1').val(line1);
        $('#editLine2').val(line2);
        $('#editCity').val(city);
        $('#editState').val(state);
        $('#editZip').val(zip);
        $('#editCountry').val(country);
    });

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

document.getElementById("edit-address-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    fetch("<?php echo URLROOT; ?>/UserController/editAddress", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Address edited successfully!");
                location.reload(); // Reload the page or update the UI dynamically
            } else {
                alert("Failed to edit address. Please try again.");
            }
        })
        .catch((error) => console.error("Error:", error));
});

    function redirectToPage(paymentOption) {
        let url = '';
        
        switch(paymentOption) {
            case 'PhonePe':
                url = 'https://www.phonepe.com/';  // Replace with your UPI page URL
                break;
                case 'GooglePay':
                url = 'https://payments.google.com/gp/w/home/signup';  // Replace with your UPI page URL
                break;
            case 'PayPal':
                url = 'paypal_page.html';  // Replace with your PayPal page URL
                break;
            case 'Stripe':
                url = 'stripe_page.html';  // Replace with your Stripe page URL
                break;
            case 'Bank':
                url = 'https://www.onlinesbi.sbi/';  // Replace with your Net Banking page URL
                break;
            default:
                break;
        }

        if (url) {
            window.location.href = url;
        }
    }
    let selectedAddressId = null;
        let selectedPaymentMethod = null;

        // Address selection
        document.querySelectorAll('.select-address-btn').forEach(button => {
            button.addEventListener('click', function() {
                selectedAddressId = this.getAttribute('data-address-id');
                document.querySelectorAll('.select-address-btn').forEach(btn => btn.classList.remove('btn-success'));
                this.classList.add('btn-success');
                enableProceedButton();
            });
        });

        // Payment method selection
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', function() {
                selectedPaymentMethod = this.value;
                enableProceedButton();
            });
        });

        // Enable proceed to payment button
        function enableProceedButton() {
            if (selectedAddressId && selectedPaymentMethod) {
                document.getElementById('proceed-to-payment').disabled = false;
            } else {
                document.getElementById('proceed-to-payment').disabled = true;
            }
        }

        // Proceed to payment
        document.getElementById('proceed-to-payment').addEventListener('click', function() {
            // Submit the form with selected address and payment method
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= URLROOT; ?>/OrderController/payment';

            let addressField = document.createElement('input');
            addressField.type = 'hidden';
            addressField.name = 'selected_address_id';
            addressField.value = selectedAddressId;
            form.appendChild(addressField);

            let paymentField = document.createElement('input');
            paymentField.type = 'hidden';
            paymentField.name = 'payment_method';
            paymentField.value = selectedPaymentMethod;
            form.appendChild(paymentField);

            document.body.appendChild(form);
            form.submit();
        });

    </script>
</body>
</html>











                    

            

        

    