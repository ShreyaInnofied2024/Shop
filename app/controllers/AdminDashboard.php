<?php
class AdminDashboard extends Controller
{
    private $report;

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
}
