<nav>
  <div>
      <?php echo SITENAME; ?>
      <a href='<?php echo URLROOT; ?>'>Home</a>
      <a href="<?php echo URLROOT; ?>/pageController/about">About</a>
          <?php if(isset($_SESSION['user_id'])) : ?>
          <a href="<?php echo URLROOT; ?>/userController/logout">Logout</a>
          <?php else : ?>
            <a href="<?php echo URLROOT; ?>/userController/register">Register</a>
            <a href="<?php echo URLROOT; ?>/userController/login">Login</a>
          <?php endif; ?>
            </div>
  </nav>