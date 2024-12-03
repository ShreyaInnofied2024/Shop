<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">View Physical Products</h1>
        <a href="<?= URLROOT; ?>/productController" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th> <!-- New column for images -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product->name); ?></td>
                        <td><?= htmlspecialchars($product->quantity); ?></td>
                        <td>Rs<?= number_format($product->price, 2); ?></td>
                        <td><?= htmlspecialchars($product->category_name); ?></td>
                        <td>
                            <?php if (!empty($product->image_path)): ?>
                                <img src="<?= URLROOT . '/' . $product->image_path; ?>" alt="Product Image" style="width: 100px; height: auto;">
                            <?php else: ?>
                                <span>No image available</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
