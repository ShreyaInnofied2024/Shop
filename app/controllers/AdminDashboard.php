<?php
class AdminDashboard extends Controller
{
    private $report;
    private $product;

    public function __construct()
    {
        $this->report = $this->model('ReportModel');
    }

    public function showDashboard()
    {
        // Fetch report data
        $totalOrders = $this->report->getTotalOrders();
        $totalRevenue = $this->report->getTotalRevenue();
      $orderStatusCounts = $this->report->getOrderStatusCounts();
      $customer=$this->report->getTotalNonAdminUsers();


        $data=[
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'orderStatusCounts'=>$orderStatusCounts,
            'customer'=>$customer
        ];
        // Pass data to the view
        $this->view('admin/dashboard',$data);
    }

    public function dailyPurchases() {
        $purchases = $this->report->getDailyPurchases();
        $data = [
            'purchases' => $purchases
        ];
        $this->view('admin/daily_purchases', $data);
    }
    
    public function paymentMethods() {
        $methods = $this->report->getPaymentMethods();
        $data = [
            'methods' => $methods
        ];
        $this->view('admin/payment_methods', $data);
    }
    
    public function revenueGraph() {
        $revenues = $this->report->getRevenueGraph();
        $data = [
            'revenues' => $revenues
        ];
        $this->view('admin/revenue_graph', $data);
    }
    


}
