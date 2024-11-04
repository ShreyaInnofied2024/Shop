<?php
class OrderController extends Controller{
    private $order;
    private $cart;

    public function __construct() {
        $this->order = $this->model('OrderModel');
        $this->cart=$this->model('CartModel');
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_ADDRESS = filter_input_array(INPUT_POST);
        $address = trim($_ADDRESS['line1']) . " " . trim($_ADDRESS['line2']) . " " .
                   trim($_ADDRESS['city']) . " " . trim($_ADDRESS['state']) . " " .
                   trim($_ADDRESS['country']) . " " . trim($_ADDRESS['zip']);
        $totalPrice = $this->cart->getTotalPrice($_SESSION['user_id']);
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'address' => $address,
            'total_amount' => $totalPrice,
            'shipping_method' => $_ADDRESS['shipping_method']
        ];

        // Save the pending order
        $orderId = $this->order->savePendingOrder($data);

        if ($orderId) {
            // Save the order ID in session to verify after PayPal callback
            $_SESSION['pending_order_id'] = $orderId;
            $data=[
                'orderId'=>$orderId,
                'totalPrice'=>$totalPrice
            ];
            if($_ADDRESS['shipping_method']=='Paypal'){
            // Redirect to PayPal with necessary data
            $this->view('paypal/index',$data);
            }
            if($_ADDRESS['shipping_method']=='Stripe'){
                $this->view('stripe/view',$data);
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
        $this->cart->clearCart($user_id);
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
            // Redirect to the cart or a cancellation view
            redirect('cartController');
        } else {
            // Handle error during deletion
            // You can log the error or show a message
            redirect('orderController/error'); // Redirect to an error handling page
        }
    } else {
        // If no pending order exists, redirect to the cart
        redirect('cartController');
    }
}

}


