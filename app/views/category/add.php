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
    <h2>Add Category</h2>
    <form action="<?php echo URLROOT; ?>/categoryController/add" method="post">
        <div class="form-group">
        <input type="text" name="name" id="name" 
                                   class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['name']; ?>" placeholder="Enter category name">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                        </div>         
        <button type="submit" class="btn login-btn btn-block">Submit</button>
    </form>
    <div class="form-footer">
  <a href="<?php echo URLROOT; ?>/categoryController" class="text-decoration-none" style="color: #a27053;">Go Back</a>
            
         </div>
</div>
    </section>
</body>
</html>

            

              
         






                       

                       


                        

                    




