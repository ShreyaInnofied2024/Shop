<?php require APPROOT . '/views/inc/header.php';?>
<a href='<?php echo URLROOT; ?>/productController/'><button>Product</button></a>
<a href='<?php echo URLROOT; ?>/categoryController/'><button>Category</button></a>
<?php if(!isAdmin()){
    echo "<a href='" . URLROOT . "/userController/changePassword/" . $_SESSION['user_email'] . "'><button>Change Password</button></a>";
    echo "<a href='" . URLROOT . "/cartController/show/'><button>Cart</button></a>";
    
}
?>
