<?php
class ReportModel
{
    private $db;
    public function __construct()
    {
        $this->db=new Database();
    }
    public function getTotalOrders()
    {
        $result = $this->db->select('orders', 'COUNT(id) AS total_orders');
        return $result[0]->total_orders;
    }

    public function getTotalRevenue()
    {
        $result = $this->db->select('orders', 'SUM(total_amount) AS total_revenue');
        return $result[0]->total_revenue;
    }
    public function getOrderStatusCounts()
    {
        $this->db->query("SELECT status, COUNT(*) AS count
                      FROM orders
                      WHERE status IN ('Pending', 'completed')
                      GROUP BY status");
        $results = $this->db->resultSet();
    
        // Initialize the counts
        $counts = [
            'Pending' => 0,
            'completed' => 0
        ];
        foreach ($results as $row) {
            if (array_key_exists($row->status, $counts)) {
                $counts[$row->status] = $row->count;
            }
        } 
    
        return $counts;
    }

    public function getTotalNonAdminUsers()
{
    $this->db->query("SELECT COUNT(*) AS total_users
                  FROM user
                  WHERE user_role != 'admin'"); // Exclude 'admin' role
    $result = $this->db->single(); // Fetch the result as a single object

    return $result->total_users; // Return the count
}

public function getRevenueByPaymentMethod() {
    // SQL query to group revenue by payment method
    $query = "
        SELECT shipping_method, SUM(total_amount) AS total_revenue
        FROM orders
        GROUP BY shipping_method
    ";

    $this->db->query($query);
    $this->db->execute();
    return $this->db->resultSet();
}

public function getRevenueByDate() {
    // SQL query to group revenue by date
    $query = "
        SELECT DATE(created_at) AS order_date, SUM(total_amount) AS total_revenue
        FROM orders
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at) DESC
    ";

    $this->db->query($query);
    $this->db->execute();
    return $this->db->resultSet();
}

public function getRevenueByProduct() {
    // SQL query to get total revenue for each product
    $query = "
        SELECT p.name AS product_name, SUM(oi.quantity * p.price) AS total_revenue
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        GROUP BY oi.product_id
        ORDER BY total_revenue DESC
    ";

    $this->db->query($query);
    $this->db->execute();
    return $this->db->resultSet();
}

    
}
