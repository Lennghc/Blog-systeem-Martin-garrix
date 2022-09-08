<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= PATH_DIR ?>/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN VIEW</div>
    </a>
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= PATH_DIR ?>/admin/blogs">
            <i class="fa fa-archive"></i>
            <span>Blogs</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= PATH_DIR ?>/admin/users">
            <i class="fa fa-users"></i>
            <span>Users</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= PATH_DIR ?>/admin/events">
            <i class="fa fa-calendar"></i>
            <span>Events</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= PATH_DIR ?>/">
            <i class="fa fa-home"></i>
            <span>Home</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= PATH_DIR ?>/auth/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span></a>
    </li>



    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
        </nav>

        <script src="<?= PATH_DIR ?>/assets/js/SideBar.js"></script>
        <script src="<?= PATH_DIR ?>/assets/js/main.js"></script>

        <?php
        if (isset($_SESSION['toast'])) {
            echo $_SESSION['toast'];
            unset($_SESSION['toast']);
        }
        
        ?>