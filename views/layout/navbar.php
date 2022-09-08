<section id="navbar">
  <div class="container-fluid pr-5 pl-5 mt-4">
    <div class="row justify-content-between">
      <div class="col">
        <a class="navbar-brand" href="#">
          <img src="<?= PATH_DIR ?>/assets/img/logo-mini.svg" class="d-inline-block align-top" alt="">
        </a>
      </div>
      <div class="col d-flex justify-content-end">
        <div class="d-flex align-items-center justify-content-center">
          <!--                <form method="GET" class="searchform d-none d-md-block">-->
          <!--                    <div class="form-group d-flex">-->
          <!--                        <input type="hidden" name="view" value="product">-->
          <!--                        <input type="hidden" name="op" value="search">-->
          <!--                        <input type="text" id="search" name="q" class="form-control pl-3" placeholder="Zoeken.." autocomplete="off">-->
          <!--                        <button type="submit" class="form-control search"><span class="fa fa-lg fa-search"></span></button>-->
          <!--                    </div>-->
          <!--                </form>-->
          <div class="dropdown">
            <a class="dropdown-toggle nav-link" id="dropdownNavbar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa-solid fa-lg fa-user"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownNavbar">
                <?= isset($_SESSION['user']) ? '<a class="dropdown-item" href="settings">Settings</a>' : '<a role="button" class="dropdown-item" data-toggle="modal" data-target="#loginModal">Login</a>'?>
                <?= isset($_SESSION['user']) ? '<a class="dropdown-item" href="auth/logout">Logout</a>' : '<a role="button" class="dropdown-item" data-toggle="modal" data-target="#registerModal">Register</a>'?>
                <?= isset($_SESSION['user']) && $_SESSION['user']->admin == 1 ? '<div class="dropdown-divider"></div>' : '' ?>
                <?= isset($_SESSION['user']) && $_SESSION['user']->admin == 1 ? '<a class="dropdown-item" href="'. PATH_DIR .'/admin">Dashboard</a>' : null ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center p-3" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= !empty(PATH_DIR) ? PATH_DIR : '/' ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= PATH_DIR ?>/blog">Blogs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= PATH_DIR ?>/events">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= PATH_DIR ?>/about">About me</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= PATH_DIR ?>/contact">Contact</a>
        </li>
      </ul>
    </div>
  </nav>
</section>