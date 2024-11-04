<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Details;


$clientId = 'AaQCSBdyDW2gD3SHdRsnnZmTE8doSP5n1Koh3Jk1YGa98ZPYLadFVH5SaZ2FMnLa_JV3Y3OwKBWlZGTf';
$clientSecret = 'EFxbVKstUzj2Liumf-yR48K1uaaPhqw_hj6-SBOkbciTTlWyWQKk6dL4SKLCGZ2bS6Em50BwLUiWWd1z';


$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($clientId, $clientSecret)
);

// Get the order ID from the request
$requestBody = json_decode(file_get_contents('php://input'), true);
$orderId = $requestBody['orderID'];

// Execute the payment
try {
    // Retrieve the payment using the order ID
    $payment = Payment::get($orderId, $apiContext);
    
    // Create a new PaymentExecution object
    $execution = new PaymentExecution();
    
    // Set the payer ID (make sure you get it from the request correctly)
    $execution->setPayerId($requestBody['payerID']); // Ensure 'payerID' is passed from the client

    // Execute the payment
    $result = $payment->execute($execution, $apiContext);
    
    // Check if the payment was successful
    if ($result->getState() == 'approved') {
        // Payment successful
        echo json_encode(['success' => true, 'payment' => $result]);
    } else {
        // Payment not approved
        echo json_encode(['success' => false, 'message' => 'Payment not approved.']);
    }
} catch (PayPalConnectionException $ex) {
    // Handle connection error (API call failed)
    echo json_encode(['error' => 'Connection error: ' . $ex->getMessage()]);
} catch (Exception $ex) {
    // Handle other exceptions
    echo json_encode(['error' => $ex->getMessage()]);
}
?>
