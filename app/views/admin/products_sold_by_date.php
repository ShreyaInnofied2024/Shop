<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Sold by Date</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<
<style>
    .bg-custom {
        background-color: #f9f7f5;
    }
</style>
</head>
<body class="bg-custom">
<div class="container mt-5">
    <h1 class="text-center mb-4">Products Sold by Date</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Total Quantity</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row->sale_date) ?></td>
                            <td><?= htmlspecialchars($row->product_name) ?></td>
                            <td><?= htmlspecialchars($row->total_quantity) ?></td>
                            <td>Rs<?= number_format($row->total_revenue, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No sales data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
