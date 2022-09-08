<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'About Me';
        include 'views/layout/header.php';
    ?>

</head>

<?php include 'views/layout/navbar.php'; ?>

<body>
<section id="about">
      <div class="container">
        <h4 class="text-center">About me</h4>
        <div class="row mt-4">
          <div class="col-md-6 col-8 mb-4">
            <img class="img-fluid rounded w-75" src="assets/img/garrix.jpg">
          </div>
          <div class="col-md-6">
            <div class="bg-trans p-5 rounded text-white">
              <h1 class="display-4">Martin Garrix</h1>
              <p class="lead">The name that belongs to one of the youngest and most successful DJ’s/producers championing the pop and electronic scene. Garrix has taken his expertise across the globe, by headlining festivals, breaking through territories, and collaborating with major stars including Dua Lipa, Khalid and Bono, and The Edge. Climbing yet another rung of his ladder to stardom, he is a founder of his very own label (STMPD RCRDS), owner of a studio complex in Amsterdam, and a mentor to upcoming artists. </p>
              <hr class="my-4">
              <p>Follow him on his socials below to stay up-to-date with his latest releases.</p>
            </div>
          </div>
        </div>
      </div>
</section>

  <?php include 'views/layout/footer.php'; ?>

</body>
</html>