<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;"><?php echo $data['category'][0]->category_name;?></h1>
        <a href="<?= URLROOT; ?>/categoryController" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data['category'] as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category->product_name); ?></td>
                        <td><?= htmlspecialchars($category->product_quantity); ?></td>
                        <td>$<?= number_format($category->product_price, 2); ?></td>
                        <td><?= htmlspecialchars($category->product_type); ?></td>
                        <td>
                            <?php if (!empty($category->product_image)): ?>
                                <img src="<?= URLROOT . '/' . $category->product_image; ?>" alt="Product Image" style="width: 100px; height: auto;">
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

