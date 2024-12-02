<?php
include('/var/www/html/shopMVC2/app/services/MailService.php');
class OrderController extends Controller{
    private $order;
    private $cart;
    private $product;
    private $user;
    private $stripeServices;

    public function __construct() {

        if(!isLoggedIn()){
            redirect('userController/login');
        }
        if(isAdmin()){
            redirect(URLROOT);
        }


        $this->order = $this->model('OrderModel');
        $this->cart=$this->model('CartModel');
        $this->product=$this->model('ProductModel');
        $this->user=$this->model('UserModel');
        $this->stripeServices = new StripeService();
    }

    public function checkout(){
        $user_id=$_SESSION['user_id'];
        $cartItems = $this->cart->getUserCart($user_id);
        $totalItems=$this->cart->getTotalItems($user_id);
        $totalPrice=$this->cart->getTotalPrice($user_id);
        $addresses = $this->order->getAddressesByUserId($user_id); // Retrieve addresses from the database
        $data=[
            'cartItems'=>$cartItems,
            'totalItems'=>$totalItems,
            'totalPrice'=>$totalPrice,
            'addresses'=>$addresses
        ];
        $this->view('order/view',$data);
    }


    public function payment() {
        $user_id = $_SESSION['user_id'];
        $cartItems = $this->cart->getUserCart($user_id); // Fetch cart items
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect form data
            $_ADDRESS = filter_input_array(INPUT_POST);
            
            // Get selected address and payment method
            $address_id = $_ADDRESS['selected_address_id']; 
        
        // Fetch the full address from the database using the selected address ID
            $fullAddress = $this->order->getAddressById($address_id, $user_id); // Assume this method fetches the full address
            $fullAddress = $fullAddress->address;
            $paymentMethod = $_ADDRESS['payment_method']; // Get the selected payment method (PayPal, Stripe, etc.)
            
            // Get total price from the cart
            $totalPrice = $this->cart->getTotalPrice($user_id); 
            
            // Prepare the order data
            $data = [
                'user_id' => $user_id,
                'address' => $fullAddress,
                'total_amount' => $totalPrice,
                'shipping_method' => $paymentMethod // Store the payment method (shipping method)
            ];
            
            // Step 1: Save the order and get the order ID
            $orderId = $this->order->savePendingOrder($data);
        
            if ($orderId) {
                // Step 2: Save the order items in the order_items table
                $this->order->saveOrderItems($orderId, $cartItems); // Link products to the order
                
                // Clear the cart after the order is saved
                $this->cart->clearCart($user_id); // Clear user's cart (optional, depending on your flow)
        
                // Step 3: Save the order ID in session to verify after PayPal callback
                $_SESSION['pending_order_id'] = $orderId;
                    
                // Step 4: Redirect based on the shipping method (PayPal or Stripe)
                $data = [
                    'orderId' => $orderId,
                    'totalPrice' => $totalPrice
                ];
                    
                if ($paymentMethod == 'PayPal') {
                    // Redirect to the PayPal payment page
                    $this->view('paypal/index', $data);
                }
                    
                if ($paymentMethod == 'Stripe') {
                    // Redirect to the Stripe checkout page
                    $checkoutURL = $this->stripeServices->createCheckoutSession($cartItems, $user_id);
                        
                    if ($checkoutURL) {
                        // Redirect to Stripe Checkout page
                        header("Location: " . $checkoutURL);
                        exit();
                    } else {
                        // Handle error for Stripe checkout creation
                        // You can add a fallback or error handling logic here
                    }
                }
            } else {
                // Handle error if order couldn't be saved
                redirect('orderController/cancel');
                exit();
            }
        }
    }
    
    
    
    


    public function success() {
        if (isset($_SESSION['pending_order_id'])) {
            $user_id = $_SESSION['user_id'];
            $orderId = $_SESSION['pending_order_id'];
    
            // Update order status to completed
            $this->order->updateOrderStatus($orderId, 'completed');
    
            // Get user's cart products and update product quantities
            $products = $this->cart->getUserCart($user_id);
            foreach ($products as $product) {
                $product_id = $product->product_id;
                $quantity = $product->cart_quantity;
                echo "Updating product_id: $product_id, quantity: $quantity\n";
                $this->product->updateproductQuantityOnPayment($product_id, $quantity);
            }
    
            // Clear the cart
            $this->cart->clearCart($user_id);
    
            // Send order confirmation email
            $user_email = $_SESSION['user_email'];
            $this->sendOrderConfirmationEmail($orderId, $user_email);
    
            // Load the success view
            $data = [];
            $this->view('paypal/success', $data);
            exit();
        }
    }
    

public function sendOrderConfirmationEmail($order_id, $user_email) {
    $username=$_SESSION['user_name'];
    // Fetch order details
    $order = $this->order->getOrderById($order_id);
    
    // Fetch order items
    $orderItems = $this->order->getOrderItems($order_id);

    // Generate email body
    $body = '<h1 style="text-align: center; color: #333;">Order Confirmation</h1>';
$body .= '<p style="font-size: 16px;">Dear <strong>' . htmlspecialchars($username) . ',</strong></p>';
$body .= '<p style="font-size: 14px;">Thank you for your order! We are pleased to inform you that your payment of Rs. ' . htmlspecialchars($order->total_amount) . ' has been processed successfully.</p>';
$body .= '<p style="font-size: 14px;">Here are the details of your order:</p>';

$body .= '<h2 style="font-size: 18px; margin-top: 20px; color: #555;">Order Details:</h2>';
$body .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$body .= '<thead><tr>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Order ID</th>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Total Amount</th>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Status</th>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Payment Method</th>';
$body .= '</tr></thead>';
$body .= '<tbody><tr>';
$body .= '<td style="text-align: center;">' . htmlspecialchars($order->order_id) . '</td>';
$body .= '<td style="text-align: center;">Rs. ' . htmlspecialchars($order->total_amount) . '</td>';
$body .= '<td style="text-align: center;">Completed</td>';
$body .= '<td style="text-align: center;">' . htmlspecialchars($order->shipping_method) . '</td>';
$body .= '</tr></tbody>';
$body .= '</table>';

$body .= '<h2 style="font-size: 18px; margin-top: 20px; color: #555;">Items in Your Order:</h2>';
$body .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$body .= '<thead><tr>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Product Name</th>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Price</th>';
$body .= '<th style="background-color: #f2f2f2; text-align: center;">Quantity</th>';
$body .= '</tr></thead>';
$body .= '<tbody>';
foreach ($orderItems as $item) {
    $body .= '<tr>';
    $body .= '<td style="text-align: center;">' . htmlspecialchars($item->product_name) . '</td>';
    $body .= '<td style="text-align: center;">Rs. ' . htmlspecialchars($item->price) . '</td>';
    $body .= '<td style="text-align: center;">'. htmlspecialchars($item->quantity) .'</td>';
    $body .= '</tr>';
}
$body .= '</tbody>';
$body .= '</table>';

$body .= '<p style="font-size: 14px;">You will receive an email confirmation shortly with more details regarding the shipping of your order.</p>';
$body .= '<p style="font-size: 14px;">If you have any questions or need further assistance, feel free to contact us at <a href="mailto:shreya@gmail.com">support@cosmeticstore.com</a>.</p>';
$body .= '<p style="font-size: 14px;">Thank you for choosing Cosmetic Store!</p>';
$body .= '<p style="font-size: 14px;">Best Regards,<br><strong>The Cosmetic Store Team</strong></p>';

if ($order->shipping_method === 'PayPal') {
    $body .= '<p style="margin-top: 20px;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal Logo" style="display: block; margin: 0 auto;"></p>';
} elseif ($order->shipping_method === 'Stripe') {
    $body .= '<p style="margin-top: 20px;"><img src="https://media.designrush.com/inspiration_images/656402/conversions/3-desktop.jpg" alt="Stripe Logo" style="width: 100%; height: auto; object-fit: cover; display: block; margin: 0 auto;"></p>';
}


    // Use your MailService or email library to send the email
    $mailService = new MailService(); // Adjust this to your actual email service
    $subject = 'Order Confirmation - Order #' . $order->order_id;
    $mailService->sendEmail($user_email, $subject, $body);
}


public function cancel() {
    if (isset($_SESSION['pending_order_id'])) {
        $orderId = $_SESSION['pending_order_id'];
        
        // First, delete the order from the database
        if ($this->order->deleteOrder($orderId)) {
            unset($_SESSION['pending_order_id']);
            $this->view('paypal/cancel',$data=[]);
        }
    } else {
        redirect('cartController');
    }
}

public function history() {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    $orders = $this->order->getUserOrders($user_id); // Fetch orders from the database

    $data = [
        'orders' => $orders
    ];

    $this->view('order/history', $data); // Pass the data to the view
}


public function details($order_id) {
    // Fetch order info (general order details)
    $orderInfo = $this->order->getOrderById($order_id);

    // Fetch order items (products in the order)
    $orderItems = $this->order->getOrderItems($order_id);

    // Prepare data to pass to the view
    $data = [
        'orderInfo' => $orderInfo,
        'orderItems' => $orderItems
    ];

    // Pass data to the view
    $this->view('order/details', $data);
}



}








