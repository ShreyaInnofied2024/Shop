<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>EDIT PRODUCT</h1>
<form action="<?php echo URLROOT; ?>/productController/edit/<?php echo $data['id'];?>" method="post">
  Name: <input type="text" name="name" class="<?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
  <span><?php echo $data['name_err']; ?></span><br>

  Quantity: <input type="text" name="quantity" class="<?php echo (!empty($data['quantity_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['quantity']; ?>">
  <span><?php echo $data['quantity_err']; ?></span><br>

  Price: <input type="text" name="price" class="<?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']; ?>">
  <span><?php echo $data['price_err']; ?></span><br>

  <label for="type">Choose a type:</label>
  <select name="type" id="type" class="<?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>">
    <option value="Physical" <?php echo ($data['type'] == 'Physical') ? 'selected' : ''; ?>>Physical</option>
    <option value="Digital" <?php echo ($data['type'] == 'Digital') ? 'selected' : ''; ?>>Digital</option>
  </select>
  <span><?php echo $data['type_err']; ?></span><br>

  <label for="category">Choose a category:</label>
<select name="category_id" id="category" class="<?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>">
    <?php foreach ($data['categories'] as $category): ?>
        <option value="<?php echo $category->id; ?>" <?php echo ($data['category'] == $category->id) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($category->name); ?>
        </option>
    <?php endforeach; ?>
</select>
<span><?php echo $data['category_err']; ?></span><br>

  <input type="submit" value="Edit Product">
</form>
<a href='<?php echo URLROOT; ?>/productController'><button type="button">Go Back</button></a>
