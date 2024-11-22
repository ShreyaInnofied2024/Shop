<?php require APPROOT . '/views/inc/header.php'; ?>

<?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) : ?>
    <?php if ($_SESSION['user_role'] == 'Customer') : ?>
        <?php require APPROOT . '/views/pages/customer.php'; ?>
        <?php
        require_once APPROOT . '/controllers/ProductController.php';
        $controller1=new ProductController();
        $controller1->allProducts();
        ?>
    <?php elseif ($_SESSION['user_role'] == 'Admin') :?>
        <?php 
    // Load Admin Dashboard Controller
    require_once APPROOT . '/controllers/AdminDashboard.php';
    $controller = new AdminDashboard();
    $controller->showDashboard();
    // $controller->getRevenueByPaymentMethod();
    
    // $controller->getRevenueByDate();

    // $controller->getRevenueByProduct();
    ?>
    <?php endif; ?>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


