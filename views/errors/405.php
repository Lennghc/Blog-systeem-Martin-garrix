<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = '405 Method Not Allowed';
    include 'views/layout/header.php';
    ?>
</head>

<?php include 'views/layout/navbar.php'; ?>

<body>

<section id="error">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-9 bg-white rounded p-5">
                <h2 class="text-dark mb-3"><?= $title ?></h2>
                <h5 class="text-dark">We didn't get that..</h5>
                <p>Click <a style="color: lightblue" href="<?= PATH_DIR ?>">here</a> to return home.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>

</body>
</html>