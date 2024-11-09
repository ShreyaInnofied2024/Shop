<!DOCTYPE html>
<html>
<head>
    <title>PayPal Integration</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AaQCSBdyDW2gD3SHdRsnnZmTE8doSP5n1Koh3Jk1YGa98ZPYLadFVH5SaZ2FMnLa_JV3Y3OwKBWlZGTf"></script>
</head>
<body>

<h1>Checkout</h1>
<div id="paypal-button-container"></div>
<button onclick="goBack()">Back</button>

<script>

function goBack() {
    window.location.href = "<?php echo URLROOT; ?>/orderController/cancel"; // Change to your desired URL
}

    var price = <?php echo json_encode($data['totalPrice']); ?>; // Use json_encode to ensure proper formatting

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: price // Specify the amount here
                    }
            }],
            application_context: {
                shipping_preference: 'NO_SHIPPING' // Options: 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS', 'GET_FROM_FILE'
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
                        // Redirect to Products/index on success
                        window.location.href = "<?php echo URLROOT; ?>/orderController/success";
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
   

</body>
</html>
