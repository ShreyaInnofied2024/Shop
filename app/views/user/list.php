<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Users</h1>
        <a href="<?= URLROOT; ?>/productController" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->name); ?></td>
                        <td><?= htmlspecialchars($user->email); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
