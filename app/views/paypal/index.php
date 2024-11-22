<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Integration</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for better UI -->
    <style>
        body {
            background-color: #f9f2ec;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 30px;
        }
        .btn-back {
            margin-top: 20px;
            text-decoration: none;
        }
        .paypal-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Checkout</h3>
        </div>
        <div class="card-body">
            <h5 class="text-center mb-4">Total Amount: $<span id="total-price"></span></h5>

            <div id="paypal-button-container" class="paypal-button"></div>

            <a href="javascript:void(0);" onclick="goBack()" class="btn btn-outline-secondary btn-back w-100">Back to Shopping</a>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AaQCSBdyDW2gD3SHdRsnnZmTE8doSP5n1Koh3Jk1YGa98ZPYLadFVH5SaZ2FMnLa_JV3Y3OwKBWlZGTf"></script>

<script>
    // Set total price dynamically
    var price = <?php echo json_encode($data['totalPrice']); ?>;
    document.getElementById('total-price').textContent = price.toFixed(2); // Display price with 2 decimal places

    function goBack() {
        window.location.href = "<?php echo URLROOT; ?>/orderController/cancel"; // Navigate back to the cancellation route
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: price // Use the price value from PHP
                    }
                }],
                application_context: {
                    shipping_preference: 'NO_SHIPPING'
                }
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert('Transaction completed by ' + details.payer.name.given_name);

                // Send transaction data to server for further processing
                fetch('/app/services/capture_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    // Redirect to success page
                    window.location.href = "<?php echo URLROOT; ?>/orderController/success";
                });
            });
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>
