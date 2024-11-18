<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('category_message'); ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Category</h1>
        <div>
            <?php if (isAdmin()): ?>
                <a href="<?= URLROOT; ?>/categoryController/add" class="btn btn-success me-2">Add Category</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['category'] as $category): ?>
                    <tr class="text-center">
                        <td><?= $category->id; ?></td>
                        <td><?= $category->name; ?></td>
                        <td><?= isset($category->quantity) ? $category->quantity : 0; ?></td>
                        <td>
                            <?php if (isAdmin()): ?>
                                <a href="<?= URLROOT; ?>/categoryController/delete/<?= $category->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <?php endif; ?>
                            <a href="<?= URLROOT; ?>/categoryController/show/<?= $category->id; ?>" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
