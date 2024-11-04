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
                    $this->db->bind(':address', $data['address']);
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
            
            
        }
    