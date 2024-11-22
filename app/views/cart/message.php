<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); // Clear message after displaying ?>
<?php endif; ?>
