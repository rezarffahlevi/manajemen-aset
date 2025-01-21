<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>PLN ICON+</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link rel="icon" href="<?= base_url('assets/img/logo_icon.png') ?>">

  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <!-- Bootstrap 3.3.2 -->
  <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link href="<?= base_url('assets/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"
    type="text/css" />
  <!-- Ionicons -->
  <link href="<?= base_url('assets/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="<?= base_url('assets/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
  <link href="<?= base_url('assets/css/skins/_all-skins.min.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
  <!-- DATA TABLES -->
  <link href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/chosen.min.css') ?>">
  <!-- SELECT 2 -->
  <link href="<?= base_url('assets/plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->

<body class="skin-purple fixed">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <a href="#" class="logo"><b>PLN</b> ICON+</a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <?php if ($this->session->userdata('level') === 'Superadmin') { ?>
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning" id="count_notif">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header" id="header_notif">10 pemberitahuan</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu" id="list_notif">
                    </ul>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?= base_url('assets/img/logo_icon.png') ?>" class="user-image" alt="User Image" />
                <span class="hidden-xs">
                  <?= $this->session->userdata('name') ?>
                </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <!-- <img src="<?= base_url('assets/img/logo_icon.png') ?>" class="img-circle" alt="User Image"
                    style="background:#fff" /> -->
                  <img src="<?= base_url('assets/img/logo_icon.png') ?>" style="height: 50px; border: 0px" alt="User Image"
                    style="background:#fff" />
                  <p>
                    <?= $this->session->userdata('nama') ?>
                    <small>
                      <?= $this->session->userdata('username') ?>
                    </small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <!-- <div class="pull-left">
                    <a href="<?= site_url('user/profile/') ?>" class="btn btn-default btn-flat">Profil</a>
                  </div> -->
                  <div class="pull-right">
                    <a href="<?= site_url('auth/logout/') ?>" class="btn btn-default btn-flat">Keluar</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->
    <?php
    $uri = $this->uri;
    // $segments       = $uri->getSegments();
    $menu_active = "";
    $submenu_active = "";
    $level = $this->session->userdata('level');
		$count_reservasi = $this->M_master->get_count_id('reservasi', 'status = "Butuh Persetujuan"')->row();

    if ($uri->total_segments() > 0) {
      $menu_active = $uri->segment(1);
      $submenu_active = $uri->segment(2);
    }

    $menu = [
      [
        'title' => 'Beranda',
        'link' => 'home',
        'icon' => 'fa-home',
        'access' => [],
      ],
      [
        'title' => 'Material Multimedia',
        'link' => 'manajemen',
        'icon' => 'fa-table',
        'access' => [],
      ],
      [
        'title' => 'Persetujuan Reservasi',
        'link' => 'reservasi',
        'icon' => 'fa-book',
        'access' => [],
      ],
      [
        'title' => 'Master Data',
        'link' => 'master',
        'icon' => 'fa-caret-square-o-down',
        'access' => ['!SPV'],
        'submenu' => [
          [
            'title' => 'User',
            'link' => 'master/user',
          ],
          [
            'title' => 'Material',
            'link' => 'master/material',
          ],
          [
            'title' => 'Rekanan',
            'link' => 'master/rekanan',
          ],
          [
            'title' => 'Storage Location',
            'link' => 'master/penyimpanan',
          ],
        ],
      ],
      [
        'title' => 'History',
        'link' => 'history',
        'icon' => 'fa-history',
        'access' => ['!SPV'],
        'submenu' => [
          [
            'title' => 'SPR',
            'link' => 'history/spr',
          ],
          [
            'title' => 'Reservasi',
            'link' => 'history/reservasi',
          ],
          [
            'title' => 'RMA',
            'link' => 'history/rma',
          ],
        ],
      ],
      // [
      //   'title'     => 'Laporan',
      //   'link'      => 'report',
      //   'icon'      => 'fa-file-text',
      //   'access'    => ['Admin'],
      // ],
    ];
    ?>
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?= base_url('assets/img/logo_icon.png') ?>" style="height: 50px; width: 105px;" alt="User Image" />
          </div>
          <div class="pull-left info">
            <p>
              <?= $this->session->userdata('nama') ?>
            </p>

            <a href="#"><i class="fa fa-circle text-success"></i> Aktif</a>
          </div>
        </div>

        <ul class="sidebar-menu" id="menu">
          <li class="header">MENU UTAMA</li>
          <?php foreach ($menu as $i => $row): ?>
            <?php
            $show = true;
            $is_menu_active = preg_match('/' . str_replace('/', '\/', $row['link']) . '/', $menu_active);
            foreach ($row['access'] as $access) {
              if ($access == $level)
                $show = true;

              if ($access == '!' . $level) {
                $show = false;
              }
            }
            if ($show):
              ?>
              <li class="<?= (!empty($row['submenu']) ? 'treeview ' : '') . ($is_menu_active ? 'active' : '') ?>">
                <a href="<?= site_url($row['link']) ?>">
                  <i class="fa <?= $row['icon'] ?>"></i> <span>
                    <?= $row['title'] ?>
                  </span>
                  <?= !empty($row['submenu']) ? "<i class='fa fa-angle-left pull-right'></i>" : "<small class='label pull-right bg-green'></small>"; ?>
									<?php 
									if($row['link'] == 'reservasi' && $count_reservasi->total > 0) { ?>
									<span class="pull-right-container">
										<small class="label pull-right bg-red"><?= $count_reservasi->total?></small>
									</span>
									<?php } ?>
								</a>
                <?php if (!empty($row['submenu'])): ?>
                  <ul class="treeview-menu">
                    <?php foreach ($row['submenu'] as $j => $sub): ?>
                      <?php $is_submenu_active = explode('/', $sub['link'])[1] == $submenu_active; ?>
                      <li class="<?= $is_submenu_active ? 'active' : '' ?>"><a href="<?= site_url($sub['link']) ?>"><i
                            class="fa fa-circle-o"></i>
                          <?= $sub['title'] ?>
                        </a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- jQuery 2.1.3 -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>

    <?php $this->load->view($content) ?>


    <!-- ============================================== -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        Versi <b>1.0 </b>
      </div>
      <strong>Copyright &copy; 2024 <a href="#">PT. Indonesia Comnet Plus</a>.</strong> All rights reserved.
      Halaman terload dalam <strong>{elapsed_time}</strong> detik.
    </footer>
  </div>
  <!-- ./wrapper -->

  <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>" type="text/javascript"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
  <!-- SlimScroll -->
  <script src="<?= base_url('assets/plugins/slimScroll/jquery.slimScroll.min.js') ?>" type="text/javascript"></script>
  <!-- FastClick -->
  <script src="<?= base_url('assets/plugins/fastclick/fastclick.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/select2/select2.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/chartjs/Chart.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/js/app.min.js') ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?= base_url('assets/js/demo.js') ?>" type="text/javascript"></script> -->
  <script type="text/javascript">
    $(".chosen-select").chosen({
      width: "100%"
    });

    // $.post("<?= base_url('home/jx_get_list_notif') ?>", function(data, status) {
    //   data  = JSON.parse(data)
    //   let html  = ''
    //   data.forEach(val => {
    //     console.log(val)
    //     html += `
    //       <li>
    //         <a href="<?= base_url('rent') ?>">
    //           <i class="fa fa-car text-aqua"></i> <b>${val.nama_pegawai}</b> memesan mobil
    //         </a>
    //       </li>
    //     `
    //   })

    //   $('#count_notif').html(data.length)
    //   $('#header_notif').html(data.length + ' permintaan')
    //   $('#list_notif').html(html)
    // });
  </script>

</body>

</html>
