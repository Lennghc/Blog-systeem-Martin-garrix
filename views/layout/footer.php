<section id="footer">
  <div class="container">
    <hr>
    <div class="row d-flex justify-content-center">
      <div class="col-md-6 brands">
          <a href="#"><img class="logo" src="<?= PATH_DIR ?>/assets/img/socials/instagram.svg" alt=""></a>
          <a href="#"><img class="logo" src="<?= PATH_DIR ?>/assets/img/socials/twitter.svg" alt=""></a>
          <a href="#"><img class="logo" src="<?= PATH_DIR ?>/assets/img/socials/facebook.svg" alt=""></a>
          <a href="#"><img class="logo" src="<?= PATH_DIR ?>/assets/img/socials/snapchat.svg" alt=""></a>
      </div>
    </div>
  </div>
</section>

<?php include 'views/layout/authModal.php'; ?>

<script src="<?= PATH_DIR ?>/assets/js/main.js"></script>
<script src="<?= PATH_DIR ?>/assets/js/authlogin.js"></script>

<?php
    if(isset($_SESSION['toast'])) {
        echo $_SESSION['toast'];
        unset($_SESSION['toast']);
    }

?>
