<?php require APPROOT . '/views/inc/header.php';?>
<h1><?php echo $data['category'][0]->category_name;?></h1>
<a href='<?php echo URLROOT; ?>/categoryController'><button>Go Back</button></a>
<table border="1">
<tr><th>Name</th><th>Quantity</th><th>Price</th><th>Type</th></tr>
<?php foreach($data['category'] as $category){
        echo "<tr>";
        echo "<td>$category->product_name</td>";
        echo "<td>$category->product_quantity</td>";
        echo "<td>$category->product_price</td>";
        echo "<td>$category->product_type</td>";
    echo"</tr>";
}
?>
    </table>
