<?php foreach ($data['products'] as $product): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product">
            <img src="/shopMVC2/public/<?= htmlspecialchars($product->image_path) ?>" 
                 class="card-img-top mx-auto img-fluid" 
                 alt="<?= htmlspecialchars($product->name) ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                <p class="card-text">$<?= number_format($product->price, 2) ?></p>
                <a href="<?= URLROOT ?>/productController/show/<?= $product->id ?>" class="btn btn-danger w-100">View</a>

                <!-- Add to Cart Button -->
                <a href="<?= URLROOT ?>/cartController/add/<?= $product->id ?>" class="btn btn-primary w-100 mt-2">Add to Cart</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
