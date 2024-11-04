<?php
class CartController extends Controller{
    private $cart;
    private $product;

    public function __construct() {
        $this->cart = $this->model('CartModel');
        $this->product=$this->model('ProductModel');
    }

    public function index(){
        $user_id=$_SESSION['user_id'];
        $cartItems = $this->cart->getUserCart($user_id);
        $totalItems=$this->cart->getTotalItems($user_id);
        $totalPrice=$this->cart->getTotalPrice($user_id);
        $data=[
            'cartItems'=>$cartItems,
            'totalItems'=>$totalItems,
            'totalPrice'=>$totalPrice
        ];
        $this->view('cart/view',$data);
    }

    // Add to cart

    public function add($product_id) {
        $user_id = $_SESSION['user_id'];
        $quantity = 1;
    
        // Get product details from the database
        $product = $this->product->getProductById($product_id);
    
        // Check if the product exists in the cart
        $cartItem = $this->cart->getCartItem($user_id, $product_id);
    
        if ($cartItem) {
            // If the product is already in the cart, check if adding one more would exceed available quantity
            $newQuantity = $cartItem->quantity + 1;
            
            if ($newQuantity <= $product->quantity) {
                // Update the quantity in the cart
                $this->cart->updateQuantity($user_id, $product_id, $newQuantity);
            } else {
                // Optional: Handle case where quantity exceeds available stock
                echo "Cannot add more than available stock.";
            }
        } else {
            // If the product is not in the cart, add it with quantity 1
            $data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
            $this->cart->addToCart($data);
        }
    
        // Redirect to the cart view
        redirect('cartController');
    }
    
  

    public function increase($product_id) {
        $user_id = $_SESSION['user_id'];
        $cartItem = $this->cart->getCartItem($user_id, $product_id);
        
        // Get the available quantity of the product
        $product = $this->product->getProductById($product_id); // Assuming you have a function to get product details
        
        if ($cartItem && $product) {
            // Check if the new quantity would exceed the available product quantity
            $newQuantity = $cartItem->quantity + 1;
            
            if ($newQuantity <= $product->quantity) {
                // Update quantity if it does not exceed available stock
                $this->cart->updateQuantity($user_id, $product_id, $newQuantity);
            }
        }
        
        redirect('cartController'); // Redirect to cart view
    }
   

    // Decrease quantity of an item in the cart
    public function decrease($product_id) {
        $user_id=$_SESSION['user_id'];
        $cartItem = $this->cart->getCartItem($user_id, $product_id);
        if ($cartItem && $cartItem->quantity > 1) {
            $newQuantity = $cartItem->quantity - 1;
            $this->cart->updateQuantity($user_id, $product_id, $newQuantity);
        } else {
            $this->cart->removeFromCart($user_id, $product_id);
        }

        redirect('cartController'); // Redirect to cart view
    }

    // Remove item from cart
    public function remove($product_id) {
        $user_id=$_SESSION['user_id'];
        $this->cart->removeFromCart($user_id, $product_id);
      
        redirect('cartController'); // Redirect to cart view
    }

    // Display cart view
    public function viewCart($user_id) {
        $cartItems = $this->cart->getUserCart($user_id);
        include 'views/cart.php';  // Load the cart view
    }

    public function clearCart() {
        $userId = $_SESSION['user_id'];
        $this->cart->clearCart($userId);

        
     }
    
}
