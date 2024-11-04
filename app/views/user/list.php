<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('product_message'); ?>
<h1>Users</h1><table border="1">
<a href='<?php echo URLROOT; ?>'><button>Home</button></a>
<tr><th>Id</th><th>Name</th><th>Email</th><th>user_role</th></tr>
    <?php foreach($data['users'] as $user){
        echo "<tr>";
        echo "<td>$user->id</td>";
        echo "<td>$user->name</td>";
        echo "<td>$user->email</td>";
        echo "</tr>";
    }
        ?>
    </table>