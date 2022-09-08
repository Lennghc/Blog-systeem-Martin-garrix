<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $title = 'Post';
        include('views/layout/header.php');
    ?>

</head>

<?php include('views/layout/navbar.php'); ?>

<body>
<section id="post">
    <div class="container">
      <div class="post-item">
        <h1><?=$result['title']?></h1>
        <h6><?=$date->format('l, d F Y')?></h6>
        <div class="jumbotron mt-3">
          <p><?=$result['content']?></p>
        </div>
      </div>
      <div class="bg-trans rounded p-4">
        <h6 id="num-comments"></h6>

        <?php if (\Classes\Functions::isLoggedin()): ?>
        <div class="add-comment pt-2">
          <form id="post-comment" method="POST">
            <div class="form-group d-flex">
                <input type="text" name="comment" class="form-control pl-3" placeholder="Add a comment..." autocomplete="off">
                <button type="submit" class="form-control click"><span class="fa fa-paper-plane"></span></button>
            </div>
          </form>
        </div>
        <?php endif ?>

        <hr>

        <div class="post-comments">
        </div>
      </div>
    </div>
  </section>

  <?php include('views/layout/footer.php'); ?>
    <script src="<?= PATH_DIR ?>/assets/js/blog.js"></script>
</body>
</html>