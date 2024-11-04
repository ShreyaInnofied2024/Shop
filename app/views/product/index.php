<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('product_message'); ?>
<h1>Products</h1>
<?php if(isAdmin()){
echo "<a href='" . URLROOT . "/productController/add'><button>Add</button></a>";
}
?>
<a href='<?php echo URLROOT; ?>'><button>Home</button></a>
<table border="1">
<tr><th>Id</th><th>Name</th><th>Quantity</th><th>Price</th><th>Type</th><th>Category</th><th>Actions</th></tr>
    <?php foreach($data['products'] as $product){
        echo "<tr>";
        echo "<td>$product->id</td>";
        echo "<td>$product->name</td>";
        echo "<td>$product->quantity</td>";
        echo "<td>$product->price</td>";
        echo "<td>$product->type</td>";
        echo "<td>$product->category_name</td>";
        echo "<td>";
        if(isAdmin()){
            echo "<a href=". URLROOT ."/productController/edit/$product->id><button>Edit</button></a>";
            echo "<a href=". URLROOT ."/productController/delete/$product->id><button>Delete</button></a>";
        }
           echo "<a href=". URLROOT ."/productController/show/$product->id><button>View</button></a>";
           if(!isAdmin()){
            echo "<a href=". URLROOT ."/cartController/add/$product->id><button>Add To Cart</button></a>";
           }
           

        echo "</td>";
        echo "</tr>";
    }
        ?>
    </table>
<a href='<?php echo URLROOT; ?>/productController/digital'><button>Digital</button></a>
<a href='<?php echo URLROOT; ?>/productController/physical'><button>Physical</button></a>
<?php if(isAdmin()){
    echo "<a href=". URLROOT ."/userController/list><button>Get All User</button></a>";       
}



    
