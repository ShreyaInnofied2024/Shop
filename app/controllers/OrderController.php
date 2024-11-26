<?php
include('/var/www/html/shopMVC2/app/services/MailService.php');
class OrderController extends Controller{
    private $order;
    private $cart;
    private $product;
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
        $this->stripeServices = new StripeService();
    }

    public function checkout(){
        $user_id=$_SESSION['user_id'];
        $cartItems = $this->cart->getUserCart($user_id);
        $totalItems=$this->cart->getTotalItems($user_id);
        $totalPrice=$this->cart->getTotalPrice($user_id);
        $data=[
            'cartItems'=>$cartItems,
            'totalItems'=>$totalItems,
            'totalPrice'=>$totalPrice
        ];
        $this->view('order/view',$data);
    }


    public function payment() {
        $user_id = $_SESSION['user_id'];
        $cartItems = $this->cart->getUserCart($user_id); // Fetch cart items
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect shipping address from the form
            $_ADDRESS = filter_input_array(INPUT_POST);
            $address = trim($_ADDRESS['line1']) . " " . trim($_ADDRESS['line2']) . " " .
                       trim($_ADDRESS['city']) . " " . trim($_ADDRESS['state']) . " " .
                       trim($_ADDRESS['country']) . " " . trim($_ADDRESS['zip']);
            $totalPrice = $this->cart->getTotalPrice($user_id); // Get total price from cart
            
            // Prepare the order data
            $data = [
                'user_id' => $user_id,
                'address' => $address,
                'total_amount' => $totalPrice,
                'shipping_method' => $_ADDRESS['shipping_method']
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
                    
                if ($_ADDRESS['shipping_method'] == 'PayPal') {
                    $this->view('paypal/index', $data);
                }
                    
                if ($_ADDRESS['shipping_method'] == 'Stripe') {
                    $checkoutURL = $this->stripeServices->createCheckoutSession($cartItems, $user_id);
                        
                    if ($checkoutURL) {
                        // Redirect to Stripe Checkout page
                        header("Location: " . $checkoutURL);
                        exit();
                    } else {
                        // Handle error for Stripe checkout creation
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
        $user_id=$_SESSION['user_id'];
        $orderId = $_SESSION['pending_order_id'];
        $this->order->updateOrderStatus($orderId, 'completed');
        $products=$this->cart->getUserCart($user_id);
        foreach ($products as $product) {
            $product_id = $product->product_id;
            $quantity = $product->quantity;
            $this->product->updateproductQuantityOnPayment($product_id, $quantity);
        }
        $this->cart->clearCart($user_id);

        $mailService = new MailService();
        $to = $_SESSION['user_email'];
        $subject = 'Order Confirmation';
        $body = 'Your order has been successfully placed !';
        $mailService->sendEmail($to, $subject, $body);
        $data=[];
        $this->view('paypal/success',$data);
        exit();
    }
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








