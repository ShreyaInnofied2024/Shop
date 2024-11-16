<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('product_message'); ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Products</h1>
        <div>
            <?php if(isAdmin()): ?>
                <a href="<?= URLROOT; ?>/productController/add" class="btn btn-success me-2">Add Product</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['products'] as $product): ?>
                    <tr class="text-center">
                        <td><?= $product->id; ?></td>
                        <td><?= $product->name; ?></td>
                        <td><?= $product->quantity; ?></td>
                        <td>$<?= number_format($product->price, 2); ?></td>
                        <td><?= ucfirst($product->type); ?></td>
                        <td><?= $product->category_name; ?></td>
                        <td>
                            <?php if(isAdmin()): ?>
                                <a href="<?= URLROOT; ?>/productController/edit/<?= $product->id; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= URLROOT; ?>/productController/delete/<?= $product->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <?php endif; ?>
                            <a href="<?= URLROOT; ?>/productController/show/<?= $product->id; ?>" class="btn btn-info btn-sm">View</a>
                            <?php if(!isAdmin()): ?>
                                <a href="<?= URLROOT; ?>/cartController/add/<?= $product->id; ?>" class="btn btn-success btn-sm">Add to Cart</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Filters and Admin Options -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            <a href="<?= URLROOT; ?>/productController/digital" class="btn btn-outline-secondary">Digital</a>
            <a href="<?= URLROOT; ?>/productController/physical" class="btn btn-outline-secondary">Physical</a>
        </div>
        <?php if(isAdmin()): ?>
            <a href="<?= URLROOT; ?>/userController/list" class="btn btn-outline-dark">Get All Users</a>
        <?php endif; ?>
    </div>
</div>
