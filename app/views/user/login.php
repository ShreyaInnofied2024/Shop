<?php require APPROOT . '/views/inc/header.php'; ?>
<h1> Login </h1>
 <form action="<?php echo URLROOT; ?>/userController/login" method="post">
 Email: <input type="email" name="email" class="<?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
    <span><?php echo $data['email_err']; ?></span><br>
Password: <input type="password" name="password" class="<?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
    <span><?php echo $data['password_err']; ?></span><br>

<input type="submit">
</form>

<a href='<?php echo URLROOT; ?>/userController/register'><button>Register</button></a>

<a href='<?php echo URLROOT; ?>'><button>Go Back</button></a>

