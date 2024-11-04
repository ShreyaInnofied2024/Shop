<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>View Physical Product</h1>
<a href='<?php echo URLROOT; ?>/productController'><button>Go Back</button></a>
<table border="1">
<tr><th>Name</th><th>Quantity</th><th>Price</th><th>Type</th><th>Category</th></tr>
<?php foreach($data['products'] as $product){
        echo "<tr>";
        echo "<td>$product->id</td>";
        echo "<td>$product->name</td>";
        echo "<td>$product->quantity</td>";
        echo "<td>$product->price</td>";
        echo "<td>$product->category_name</td>";
    echo "</tr>";
}
    ?>
    </table>