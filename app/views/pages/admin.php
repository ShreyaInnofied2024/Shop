<div class="container-fluid mt-4">
    <div class="row">
        <!-- Dashboard Header -->
        <div class="col-12 text-center mb-4">
            <h2 class="text-uppercase" style="color: #a27053;">Admin Dashboard</h2>
        </div>

        <!-- Summary Cards -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card text-white bg-primary shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <h3><?php echo $data['totalOrders']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <h3>$<?= number_format($data['totalRevenue'], 2); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pending Orders</h5>
                        <h3><?= $data['orderStatusCounts']['Pending']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Completed Orders</h5>
                        <h3><?= $data['orderStatusCounts']['completed']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Summary -->
        <div class="col-12 text-center">
            <div class="card shadow bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h3><?= $data['customer']; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
