<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>View Product</h1>
<a href='<?php echo URLROOT; ?>/productController'><button>Go Back</button></a>
<table border="1">
<tr><th>Name</th><th>Quantity</th><th>Price</th><th>Type</th><th>Category</th></tr>
        <tr>
        <td><?php echo $data['product']->name; ?></td>
        <td><?php echo $data['product']->quantity; ?></td>
        <td><?php echo $data['product']->price; ?></td>
        <td><?php echo $data['product']->type; ?></td>
        <td><?php echo $data['product']->category_name;?></td>
    </tr>
    </table>

    