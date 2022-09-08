<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = 'Home';
    include 'views/layout/header.php';
    ?>
</head>

<?php include 'views/layout/navbar.php'; ?>

<body>
    <section id="posts">
        <div class="container">
            <h4 class="text-center mb-4">Latest posts</h4>
            <?= !empty($html) ? $html : null ?>
        </div>
    </section>


    <section id="about">
        <div class="container">
            <h4 class="text-center">About me crew</h4>
            <div class="row mt-4">
                <div class="col-md-6 text-center">
                    <img class="img-fluid rounded" src="assets/img/teamGarrix.jpg">
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="bg-trans p-5 rounded text-white">
                        <h1 class="display-4">Team Garrix</h1>
                        <p class="lead">Lorem ipsum dolor sit amet, consectetur semper massa. Mauris vel sollicitudin nisi, at accumsan mi. Aliquam suscipit ornare nisi ut fermentum.
                        </p>
                        <hr class="my-4">
                        <p>Follow him on his socials below to stay up-to-date with his latest releases.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= !empty($event) ? $event : null ?>

    <?php include 'views/layout/footer.php'; ?>
</body>

</html>