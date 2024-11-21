<div class="container my-5">
    <h3 class="text-center">Daily Product Purchases</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Product Name</th>
                <th>Quantity Sold</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['purchases'] as $purchase): ?>
                <tr>
                    <td><?= htmlspecialchars($purchase->product_name); ?></td>
                    <td><?= htmlspecialchars($purchase->total_quantity_sold); ?></td>
                    <td><?= htmlspecialchars($purchase->purchase_date); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
