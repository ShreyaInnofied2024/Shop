<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">View Product</h1>
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
                    <th>Type</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $data['product']->name; ?></td>
                    <td><?= $data['product']->quantity; ?></td>
                    <td>$<?= number_format($data['product']->price, 2); ?></td>
                    <td><?= ucfirst($data['product']->type); ?></td>
                    <td><?= $data['product']->category_name; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
