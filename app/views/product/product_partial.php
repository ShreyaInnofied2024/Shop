<?php foreach ($data['products'] as $product) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="<?= URLROOT ?>/productController/show/<?= $product->id ?>" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0">
                        <!-- Product Image -->
                        <img src="/shopMVC2/public/<?= htmlspecialchars($product->image_path) ?>" class="card-img-top img-fluid p-3 rounded" alt="<?= htmlspecialchars($product->name) ?>" style="height: 200px; object-fit: cover;">

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column justify-content-between text-center">
                            <!-- Product Name -->
                            <h6 class="card-title text-truncate"><?= htmlspecialchars($product->name) ?></h6>

                            <!-- Price -->
                            <p class="text-muted mb-1">Rs <?= number_format($product->price, 2) ?></p>

                            <!-- Stock Logic -->
                            <div class="mt-auto">
                                <?php if ($product->quantity > 0): ?>
                                    <p class="text-success small"><?= $product->stock_message ?></p>
                                    <a href="<?= URLROOT ?>/cartController/add/<?= $product->id ?>"
                                       class="btn btn-primary btn-sm w-100">Add to Cart</a>
                                <?php else: ?>
                                    <p class="text-danger small"><?= $product->stock_message ?></p>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Notify Me</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    
