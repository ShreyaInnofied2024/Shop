<?php
include('/var/www/html/shopMVC2/app/services/MailService.php');
class OrderController extends Controller{
    private $order;
    private $cart;
    private $product;

    public function __construct() {
        $this->order = $this->model('OrderModel');
        $this->cart=$this->model('CartModel');
        $this->product=$this->model('ProductModel');
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
            $this->view('paypal/index',$data);
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
        $to = $user_id;
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

}



