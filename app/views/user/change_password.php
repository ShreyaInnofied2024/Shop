
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Change Password</h2>
                    <form action="<?php echo URLROOT; ?>/userController/changePassword/<?php echo $data['email']; ?>" method="post">
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['email']; ?>" placeholder="Enter your email">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['password']; ?>" placeholder="Enter your new password">
                            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                    <div class="mt-4 text-center">
                        <a href="<?php echo URLROOT; ?>/userController/login" class="btn btn-link">Login</a>
                        <a href="<?php echo URLROOT; ?>" class="btn btn-link">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
