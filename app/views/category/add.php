<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>ADD CATEGORY</h1>
<form action="<?php echo URLROOT; ?>/categoryController/add" method="post">
    Name: <input type="text" name="name" class="<?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
    <span><?php echo $data['name_err']; ?></span><br>
    <input type="submit">
</form>
<a href='<?php echo URLROOT; ?>/categoryController'><button>Go Back</button></a>
 
