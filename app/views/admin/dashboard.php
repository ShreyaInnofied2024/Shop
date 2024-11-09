<h2>Admin Dashboard</h2>

<div>
    <h3>Total Orders: <?= $data['totalOrders']; ?></h3>
    <h3>Total Revenue: $<?= number_format($data['totalRevenue'], 2); ?></h3>

    <h3>Order Status Summary</h3>
<ul>
    <li>Pending Orders: <?= $data['orderStatusCounts']['Pending']; ?></li>
    <li>Completed Orders: <?= $data['orderStatusCounts']['completed']; ?></li>
</ul>
<h3>Total Customer: <?= $data['customer']; ?></h3>

<a href="<?php echo URLROOT; ?>" style="text-decoration: none;">
            <button>Home</button>
        </a>


</div>
