<?php

use \Stripe\Stripe;
use \Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey('sk_test_51QHLCJJy7zc4Nas6xOrLovY4eG79MKYQbWg8r0XIg2kWU8caARq4MNCy8XlmNC4sQoMgQAxBq37aKnTGeLBp9fDG001GHElIuw'); // Replace with your own secret key
}

    public function createCheckoutSession($cartItems, $userId)
    {
        // Prepare line items from cart items
        $line_items = array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $item->product_name,
                    ],
                    'unit_amount' => $item->price * 100, // Stripe expects amount in cents
                ],
                'quantity' => $item->cart_quantity,
            ];
        }, $cartItems);

        try {
            // Create a Stripe Checkout session
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => URLROOT . '/orderController/success',
                'cancel_url' => URLROOT . '/orderController/cancel',
            ]);

            // die(var_dump($checkout_session));
            return $checkout_session->url;
        } catch (Exception $e) {
            error_log('Stripe error: ' . $e->getMessage());
            return false;
        }
    }
}

