
<ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #22228a;">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user/index'); ?>" style="background-color: #22228a;">
    <!-- <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-school"></i>
    </div> -->
    <span style="background-color: white; padding: 3px; margin-left: 12px; border-radius: 25%;">
      <img src="<?= base_url('assets/img/logo_umtas.png') ?>" alt="" style="width: 50px;">
    </span>
    <div class="sidebar-brand-text mx-3">Pengelolaan Surat<span style="color: #22228a;">_</span>Keluar</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!--Query untuk Menu -->
  <?php
  $role_id   = $this->session->userdata('role_id');

  $queryMenu = "SELECT `user_menu`.`id`, `menu`
                  FROM `user_menu`  JOIN `user_access_menu` 
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                 WHERE `user_access_menu`.`role_id` = $role_id
              ORDER BY `user_access_menu` .`menu_id` ASC 
              ";

  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- LOOPING MENU -->
  <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
      <?= $m['menu']; ?>
    </div>

    <!-- SUB MENU SESUAI MENUNYA -->
    <?php
    $menuId = $m['id'];
    $querySubMenu = "SELECT *
                       FROM `user_sub_menu`  JOIN `user_menu` 
                         ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                      WHERE `user_sub_menu`.`menu_id` = $menuId
                        AND `user_sub_menu`.`is_active` = 1             
                     ";
    $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>

    <!-- ISIAN SUB MENU -->
    <?php foreach ($subMenu as $sm) : ?>
      <?php if ($title == $sm['title']) : ?>
        <li class="navbar navbar-inverse" style="border-radius: 24px; margin-left: 6px; margin-right: 6px; padding-left: 6px; padding-top: 3px;">
          <style type="text/css">
            .navbar-inverse {
              background-color: white;
            }
            a {
                color: #22228a;
                text-decoration: none;
                background-color: transparent;
            }
            .btn-primary {
                color: #fff;
                background-color: #22228a;
                border-color: #22228a;
            }
            .btn-primary:hover {
                color: #fff;
                background-color: #22228a;
                border-color: #22228a;
            }
          </style>
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>

        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
          <i class="<?= $sm['icon']; ?>"></i>
          <span><?= $sm['title']; ?></span></a>
        </li>
      <?php endforeach; ?>

      <!-- Divider -->
      <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <?php if ($this->session->userdata('role_id') == 2): ?>
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      <?php endif ?>
    </div>
</ul>

<!-- End of Sidebar