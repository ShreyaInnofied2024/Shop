<?php

    class OrderModel {
        private $db;
    
        public function __construct() {
            $this->db = new Database; // Assume $database is a PDO instance
        }
    
        public function payment($data) {
                $this->db->query("INSERT INTO orders (user_id, address, total_amount, shipping_method) 
                                  VALUES (:user_id, :address, :total_amount, :shipping_method)");
                $this->db->bind(':user_id', $data['user_id']);
                $this->db->bind(':address', $data['address']);
                $this->db->bind(':total_amount', $data['total_amount']);
                $this->db->bind(':shipping_method', $data['shipping_method']);
    
                // Execute the statement
                if ($this->db->execute()) {
                    return true; // Payment data stored successfully
                } else {
                    return false; // Failed to store payment data
                }
            }

            public function savePendingOrder($data) {
                try {
                    $this->db->beginTransaction();
                    
                    $this->db->query("INSERT INTO orders (user_id, address, total_amount, shipping_method, status) 
                                      VALUES (:user_id, :address, :total_amount, :shipping_method, 'pending')");
                    $this->db->bind(':user_id', $data['user_id']);
                    $this->db->bind(':address', $data['address'],PDO::PARAM_STR);
                    $this->db->bind(':total_amount', $data['total_amount']);
                    $this->db->bind(':shipping_method', $data['shipping_method']);
            
                    if ($this->db->execute()) {
                        // Get the last inserted order ID for future reference
                        $orderId = $this->db->lastInsertId();
                        $this->db->commit();
                        return $orderId;  // Return order ID for redirect to PayPal
                    } else {
                        $this->db->rollBack();
                        return false;
                    }
                } catch (Exception $e) {
                    $this->db->rollBack();
                    return false;
                }
            }

            public function updateOrderStatus($orderId, $status) {
                $this->db->query("UPDATE orders SET status = :status WHERE id = :order_id");
                $this->db->bind(':status', $status);
                $this->db->bind(':order_id', $orderId);
                return $this->db->execute();
            }
            
            public function deleteOrder($orderId) {
                $this->db->query("DELETE FROM orders WHERE id = :order_id");
                $this->db->bind(':order_id', $orderId);
                return $this->db->execute();
            }

            public function getUserOrders($user_id) {
                $this->db->query("
                    SELECT o.id, o.total_amount, o.status, o.created_at, o.shipping_method
                    FROM orders o
                    WHERE o.user_id = :user_id AND o.status = 'Completed'
                    ORDER BY o.created_at DESC
                ");
                $this->db->bind(':user_id', $user_id);
                return $this->db->resultSet(); // Fetch all matching rows
            }
            
          
            public function getOrderById($order_id) {
                $this->db->query("
                    SELECT 
                        o.id AS order_id,
                        o.user_id,
                        o.total_amount,
                        o.status,
                        o.shipping_method,
                        o.created_at,
                        o.updated_at
                    FROM orders o
                    WHERE o.id = :order_id
                ");
                $this->db->bind(':order_id', $order_id);
                return $this->db->single();
            }

            public function getOrderItems($order_id) {
                $this->db->query("
                    SELECT p.name AS product_name, oi.quantity, oi.price, (oi.quantity * oi.price) AS total_price
                    FROM order_items oi
                    INNER JOIN product p ON oi.product_id = p.id
                    WHERE oi.order_id = :order_id
                ");
                $this->db->bind(':order_id', $order_id);
                return $this->db->resultSet(); // Fetch all items in the order
            }
            

            public function saveOrderItems($orderId, $cartItems) {
                foreach ($cartItems as $item) {
                    $this->db->query("
                        INSERT INTO order_items (order_id, product_id, quantity, price) 
                        VALUES (:order_id, :product_id, :quantity, :price)
                    ");
                    $this->db->bind(':order_id', $orderId);
                    $this->db->bind(':product_id', $item->product_id);
                    $this->db->bind(':quantity', $item->cart_quantity);
                    $this->db->bind(':price', $item->price);
                    $this->db->execute();
                }
            }

// In UserModel.php
public function getAddressesByUserId($userId) {
    $sql = "SELECT * FROM addresses WHERE user_id = :user_id";
    $this->db->query($sql);
    $this->db->bind(':user_id', $userId, PDO::PARAM_INT);
    $this->db->execute();
    return $this->db->resultSet(); // Return all addresses as an associative array
}

public function getAddressById($addressId, $userId) {
    // Query to fetch the full address for the given address ID and user ID
    $query = "SELECT address FROM addresses WHERE id = :address_id AND user_id = :user_id";
    
    // Prepare the query
    $this->db->query($query);
    
    // Bind the parameters
    $this->db->bind(':address_id', $addressId, PDO::PARAM_INT);
    $this->db->bind(':user_id', $userId, PDO::PARAM_INT);
    
    // Execute the query
    $this->db->execute();

    // Fetch the address
    $address = $this->db->single(); // This should return a single result

    return $address;
}




            
            
            
            
            
            
            
            
            
            
            
            
        }
    