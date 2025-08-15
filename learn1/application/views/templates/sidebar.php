<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url($role) ?>">
        <div class="sidebar-brand-text mx-3"><?= ucfirst($role) ?> Page</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    foreach ($menu as $m): ?>
        <div class="sidebar-heading pt-2"><?= $m['menu'] ?></div>

        <?php
        foreach ($submenus[$m['id']] as $sm): ?>
            <li class="nav-item ">
                <a class="nav-link pb-1 pt-1" href="<?= base_url($sm['url']) ?>">
                    <span><?= $sm['submenu'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    <?php 
    endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->