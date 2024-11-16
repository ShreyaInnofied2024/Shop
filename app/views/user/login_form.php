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
<body>
<section id="login"> 
<div class="login-container">
    <h2>Cosmetic Store</h2>
    <p>Please log in to continue shopping.</p>
    <form action="<?php echo URLROOT; ?>/userController/login" method="post">
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn login-btn btn-block">Login</button>
    </form>
    <div class="form-footer">
        <p>Don't have an account? <a href="<?php echo URLROOT; ?>/userController/register">Sign up</a></p>
    </div>
</div>
    </section>
</body>
</html>