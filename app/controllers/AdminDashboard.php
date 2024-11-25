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

    public function dashboard() {
        $revenueByDate = $this->report->getRevenueByDate();
        $revenueByPaymentMethod = $this->report->getRevenueByPaymentMethod();

        $data=[
            'revenueByDate' => $revenueByDate,
            'revenueByPaymentMethod' => $revenueByPaymentMethod
        ];
    
        $this->view('admin/admin_dashboard', $data);
    }
    
    public function productsSoldByDate() {
        $data = $this->report->getProductsSoldGroupedByDate(); // Fetch data from the model
        $this->view('admin/products_sold_by_date', $data);   // Load the view with data
    }
    
}
