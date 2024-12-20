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
    <h2>Edit Product</h2>
    <form action="<?php echo URLROOT; ?>/productController/edit/<?php echo $data['id'];?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <label for="name" class="form-label">Name</label>
                           
        <input type="text" name="name" id="name" 
        
                                   class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['name']; ?>" placeholder="Enter product name">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                        </div>
        <div class="form-group">
        <label for="quantity" class="form-label">Quantity</label>
                           
        <input type="text" name="quantity" id="quantity" 
                                   class="form-control <?php echo (!empty($data['quantity_err'])) ? 'is-inalid' : ''; ?>" 
                                   value="<?php echo $data['quantity']; ?>" placeholder="Enter quantity">
                            <span class="invalid-feedback"><?php echo $data['quantity_err']; ?></span>
                        </div>
                        <div class="form-group">
                        <label for="price" class="form-label">Price</label>
                           
                        <input type="text" name="price" id="price" 
                                   class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['price']; ?>" placeholder="Enter price">
                            <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
                        </div>
                        <div class="form-group">
    <label>Existing Images</label>
    <div class="existing-images">
        <?php foreach ($data['existing_images'] as $image): ?>
            <div class="image-container" style="display: inline-block; margin: 10px; text-align: center;">
                <img src="<?php echo URLROOT . '/' . $image->image_path; ?>" alt="Product Image" style="width: 100px; height: auto;">
                <br>
                <a href="<?php echo URLROOT; ?>/productController/deleteImage/<?php echo $image->id; ?>" class="btn btn-danger btn-sm mt-2"
                   onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-group">
    <label for="images">Add New Images</label>
    <input type="file" name="images[]" multiple class="form-control">
</div>
                        

                        <div class="form-group">
                        <label for="type" class="form-label">Product Type</label>
                            <select name="type" id="type" 
                                    class="form-select <?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>">
                                <option value="Physical" <?php echo ($data['type'] == 'Physical') ? 'selected' : ''; ?>>Physical</option>
                                <option value="Digital" <?php echo ($data['type'] == 'Digital') ? 'selected' : ''; ?>>Digital</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['type_err']; ?></span>
                        </div>

                        <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                            <select name="category_id" id="category" 
                                    class="form-select <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>">
                                <?php foreach ($data['categories'] as $category): ?>
                                    <option value="<?php echo $category->id; ?>" 
                                            <?php echo ($data['category'] == $category->id) ? 'selected' : ''; ?>>
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['category_err']; ?></span>
                         </div>

                        
                        
        <button type="submit" class="btn login-btn btn-block">Submit</button>
    </form>
    <div class="form-footer">
  <a href="<?php echo URLROOT; ?>/productController" class="text-decoration-none" style="color: #a27053;">Go Back</a>
            
         </div>
</div>
    </section>
</body>
</html>

            

              
         






                       

                       


                        

                    









