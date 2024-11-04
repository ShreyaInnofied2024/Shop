<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('category_message'); ?>
<h1>Categories</h1>
<?php if(isAdmin()){
    echo "<a href='" . URLROOT . "/categoryController/add'><button>Add</button></a>";
}
?>
<a href='<?php echo URLROOT; ?>'><button>Home</button></a>
<table border="1">
<tr><th>Id</th><th>Name</th><th>Quantity</th><th>Actions</th></tr>
    <?php foreach($data['category'] as $category){
        echo "<tr>";
        echo "<td>$category->id</td>";
        echo "<td>$category->name</td>";
        echo "<td>" . (isset($category->quantity) ? $category->quantity : 0) . "</td>";
        echo "<td>";
        if(isAdmin()){
            echo "<a href=". URLROOT ."/categoryController/delete/$category->id><button>Delete</button></a>";
        }
            echo "<a href=". URLROOT ."/categoryController/show/$category->id><button>View</button></a>";
        echo "</td>";
        echo "</tr>";
    }
        ?>
    </table>