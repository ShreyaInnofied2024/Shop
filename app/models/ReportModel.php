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

public function getDailyPurchases() {
    $this->db->query("SELECT 
    p.name AS product_name,
    SUM(c.quantity) AS total_quantity_sold,
    DATE(o.created_at) AS purchase_date
FROM 
    cart c
JOIN 
    product p ON c.product_id = p.id
JOIN 
    orders o ON c.user_id = o.user_id
WHERE 
    DATE(o.created_at) = CURDATE() -- Filter for today's purchases
GROUP BY 
    p.id, DATE(o.created_at)
ORDER BY 
    purchase_date DESC
");

    return $this->db->resultSet();
}

public function getPaymentMethods() {
    $this->db->query("SELECT shipping_method AS payment_method, COUNT(*) AS method_count 
                      FROM orders 
                      GROUP BY shipping_method");
    return $this->db->resultSet();
}

public function getRevenueGraph() {
    $this->db->query("SELECT DATE(created_at) AS revenue_date, SUM(total_amount) AS daily_revenue 
                      FROM orders 
                      GROUP BY DATE(created_at)
                      ORDER BY revenue_date ASC");
    return $this->db->resultSet();
}

    
}
