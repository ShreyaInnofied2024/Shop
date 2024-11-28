<?php
class CartModel {
    private $db;

    public function __construct() {
        $this->db = new Database; 
    }

    public function addToCart($data) {
        $existingItem = $this->getCartItem($data['user_id'], $data['product_id']);
        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $data['quantity'];
            return $this->updateQuantity($data['user_id'], $data['product_id'], $newQuantity);
        } else {
            $this->db->query("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':quantity', $data['quantity']);
            return $this->db->execute();
        }
    }

    // Get a specific cart item for a user
    public function getCartItem($user_id, $product_id) {
        $this->db->query("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->single();
    }


    

    // Update the quantity of a product in the cart
    public function updateQuantity($user_id, $product_id, $quantity) {
        $this->db->query("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
    }

    // Remove an item from the cart
    public function removeFromCart($user_id, $product_id) {
        $this->db->query("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
    }


    public function getUserCart($user_id) {
        $sql = "
            SELECT 
                c.product_id,
                p.name AS product_name,
                p.price,
                c.quantity AS cart_quantity,
                -- Get the first image path
                (SELECT pi.image_path FROM product_images pi WHERE pi.product_id = p.id LIMIT 1) AS image_path
            FROM 
                cart c
            JOIN 
                product p ON c.product_id = p.id
            WHERE 
                c.user_id = :user_id
            AND 
                p.is_deleted = FALSE
        ";
    
        $this->db->query($sql);
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    
        public function getTotalItems($user_id) {
            $this->db->query("SELECT SUM(cart.quantity) AS total_items
        FROM cart
        JOIN product p ON cart.product_id = p.id
        WHERE cart.user_id = :user_id AND p.is_deleted = FALSE");
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->single();
            return $result ? (int)$result->total_items : 0;
        }

        
        public function getTotalPrice($user_id) {
            $this->db->query("SELECT SUM(product.price * cart.quantity) AS total_price 
                              FROM cart 
                              JOIN product ON cart.product_id = product.id 
                              WHERE cart.user_id = :user_id AND product.is_deleted = FALSE");
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->single();
            return $result ? (float)$result->total_price : 0.0;
        }

        public function clearCart($userId) {
            $this->db->query("DELETE FROM cart WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            return $this->db->execute();
        }

        public function assignOrderIdToCart($user_id, $order_id) {
            $this->db->query("UPDATE cart SET order_id = :order_id WHERE user_id = :user_id AND order_id IS NULL");
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':user_id', $user_id);
            return $this->db->execute(); // Update cart with order_id
        }
        public function getActiveProductCount($userId)
        {
            // SQL Query to count distinct active products in the cart
            $sql = "
                SELECT COUNT(DISTINCT cart.product_id) AS product_count
                FROM cart
                JOIN product p ON cart.product_id = p.id
                WHERE cart.user_id = :user_id AND p.is_deleted = FALSE
            ";
        
            // Prepare and execute the query
            $this->db->query($sql);
            $this->db->bind(':user_id', $userId);
        
            // Fetch the result
            $result = $this->db->single();
        
            // Return the product count (default to 0 if no result found)
            return $result->product_count;
        }
        
        
        
        
    }

