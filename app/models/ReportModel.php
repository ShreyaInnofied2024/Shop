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

    
}
