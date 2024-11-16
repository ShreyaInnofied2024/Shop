<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="/shopMVC2/public/css/style.css">
   <script src="index.js"></script>
   <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>
    <header>

<?php require APPROOT . '/views/inc/header.php'; ?>
    </header>

<body>
<section id="login">
<div class="login-container">
    <h2>Change Password</h2>
    <p>Update your account password.</p>
    <form action="<?php echo URLROOT; ?>/userController/changePassword/<?php echo $data['email']; ?>" method="post">
        <div class="form-group">
                    <input type="email" name="email" id="email" 
                           class="form-control rounded-pill <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                           value="<?php echo $data['email']; ?>" placeholder="Enter your email" required>
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
</div>
        <div class="form-group">
                    <input type="password" name="password" id="password" 
                           class="form-control rounded-pill <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                           placeholder="Enter your new password" required>
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
        <button type="submit" class="btn login-btn btn-block">Submit</button>
    </form>
    <div class="form-footer">
    <a href="<?php echo URLROOT; ?>/userController/login" class="text-decoration-none" style="color: #a27053;">Login</a> | 
                <a href="<?php echo URLROOT; ?>" class="text-decoration-none" style="color: #a27053;">Go Back</a>
            
         </div>
</div>
    </section>
</body>
</html>

            

              
         
