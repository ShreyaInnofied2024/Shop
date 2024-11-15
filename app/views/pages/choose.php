<?php require APPROOT . '/views/inc/header.php'; ?>

<?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) : ?>
    <?php if ($_SESSION['user_role'] == 'Customer') : ?>
        <?php require APPROOT . '/views/pages/customer.php'; ?>
    <?php elseif ($_SESSION['user_role'] == 'Admin') : ?>
        <?php require APPROOT . '/views/pages/admin.php'; ?>
    <?php endif; ?>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


