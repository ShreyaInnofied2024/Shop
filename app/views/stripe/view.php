<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Stripe Payment</h1>
    <form id="payment-form">
        <div id="card-element"><!-- A Stripe Element will be inserted here. --></div>
        <button id="submit">Pay</button>
        <div id="card-errors" role="alert"></div>
    </form>

    <script>
        // Initialize Stripe
        const stripe = Stripe('pk_test_51QHLCJJy7zc4Nas6tA9KBVJRzpkYZkHPlj5TgonUhIqfdUGPJ5RT3iPd0zov2xalxMFH7GG4XibUS3CSwhRg0KdM00PFF9CGjL'); // Replace with your own publishable key
        const elements = stripe.elements();

        // Create an instance of the card Element
        const card = elements.create('card');

        // Add an instance of the card Element into the `card-element` div
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element
        card.on('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                // Show error in payment form
                const displayError = document.getElementById('card-errors');
                displayError.textContent = error.message;
            } else {
                // Send paymentMethod.id to your server (see Step 5)
                handlePaymentMethod(paymentMethod.id);
            }
        });

        async function handlePaymentMethod(paymentMethodId) {
    try {
        const response = await fetch('/shopMVC2/app/services/stripe.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ paymentMethodId }),
        });

        const responseText = await response.text(); // Get raw response text
        console.log('Server response:', responseText); // Log it to inspect

        if (!response.ok) {
            throw new Error('Payment processing failed. Please try again later.');
        }

        // Attempt to parse the JSON if response was OK
        const data = JSON.parse(responseText);

        if (data.error) {
            document.getElementById('card-errors').textContent = data.error;
        } else {
            console.log('Payment successful!', data);
            alert('Payment successful!');
        }
    } catch (error) {
        document.getElementById('card-errors').textContent = error.message;
        console.error('Error handling payment method:', error);
    }
}


    </script>
</body>
</html>