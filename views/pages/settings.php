<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'User Settings';
        include 'views/layout/header.php';
    ?>

</head>

<?php include 'views/layout/navbar.php'; ?>

<body>

<section id="settings">
    <div class="container">
        <h4 class="text-center">User Settings</h4>
        <div class="d-flex justify-content-center">
    </div>

    <?= !empty($html) ? $html : null ?>

</section>

        <?php include 'views/layout/footer.php'; ?>

</body>
</html>