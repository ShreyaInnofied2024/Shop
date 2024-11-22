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

    public function getRevenueByPaymentMethod() {
        $data = $this->report->getRevenueByPaymentMethod();
        $this->view('admin/revenue_by_payment_method', ['data' => $data]);
    }

    // Fetch and display revenue by date
    public function getRevenueByDate() {
        $data = $this->report->getRevenueByDate();
        $this->view('admin/revenue_by_date', ['data' => $data]);
    }

    // Fetch and display revenue by product
    public function getRevenueByProduct() {
        $data = $this->report->getRevenueByProduct();
        $this->view('admin/revenue_by_product', ['data' => $data]);
    }
}
