<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'Events';
        include 'views/layout/header.php';
    ?>

</head>

    <?php include 'views/layout/navbar.php'; ?>

<body>
    <?= !empty($html) ? $html : null ?>
    <?php include 'views/layout/footer.php'; ?>

</body>
</html>