<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'vendor/autoload.php'; // Load Composer's autoloader

\Stripe\Stripe::setApiKey('sk_test_51QHLCJJy7zc4Nas6xOrLovY4eG79MKYQbWg8r0XIg2kWU8caARq4MNCy8XlmNC4sQoMgQAxBq37aKnTGeLBp9fDG001GHElIuw'); // Replace with your own secret key

// Get the JSON body from the request
$input = json_decode(file_get_contents('php://input'), true);
$paymentMethodId = $input['paymentMethodId'] ?? null;

header('Content-Type: application/json'); // Ensure the response is JSON

if (!$paymentMethodId) {
    echo json_encode(['error' => 'Payment method ID is missing.']);
    exit;
}

try {
    // Create a PaymentIntent with the order amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 2000, // Amount in cents (e.g., $20.00)
        'currency' => 'usd', // Currency
        'payment_method' => $paymentMethodId,
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    // Respond with the status of the payment
    echo json_encode(['success' => true, 'paymentIntent' => $paymentIntent]);
} catch (\Stripe\Exception\CardException $e) {
    // Handle the error
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    // Catch any other exceptions
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>
