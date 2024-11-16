<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
                </li>
                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) : ?>
                    <?php if ($_SESSION['user_role'] == 'Customer') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#product">Shop</a>
                        </li>
                        <!-- <li class="nav-item active">
                            <a class="nav-link" href="#arrivals">New Arrivals</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#offer">Offers</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/userController/changePassword/<?php echo $_SESSION['user_email']; ?>">Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/cartController">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/userController/logout">Logout</a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] == 'Admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/productController">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/categoryController">Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/userController/logout">Logout</a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/userController/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/userController/login">Login</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
