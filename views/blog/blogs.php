<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'Posts';
        include 'views/layout/header.php';
    ?>

</head>

<?php include 'views/layout/navbar.php'; ?>

<body>
<section id="posts">
  <div class="container">
    <h4 class="text-center mb-4">All Posts</h4>
      <?= $html ?>
  </div>
</section>

  <?php include 'views/layout/footer.php'; ?>
</body>
</html>