<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>ICON+ SBU Jakarta </title>
  
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="icon" href="<?= base_url('assets/img/logo_icon.png') ?>">
  <!-- Bootstrap -->
  <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url('assets/plugins/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?= base_url('assets/plugins/nprogress/nprogress.css') ?>" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?= base_url('assets/plugins/animate.css/animate.min.css') ?>" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?= base_url('assets/css/custom.min.css') ?>" rel="stylesheet">
</head>

<body class="login">
  <div class="login_wrapper">
    <div class="login-logo" align='center'>
      <img src="<?= base_url('assets/img/logo_icon.png') ?>" height="65%" width="65%">
      <h2 class="asset">Jakarta</h2>
    </div>
    <center>
    </center>
    <!-- <div class="animate form login_form"> -->
    <section class="login_content">
      <form method="POST" action="<?= site_url('auth/validate/') ?>">
        <h1>Login Form</h1>
        <div>
          <input type="text" name="username" id="username" class="form-control" placeholder="Username" required=""
            value="<?= $this->session->flashdata('username') ?>">
        </div>
        <div>
          <input type="password" name="password" class="form-control" placeholder="Password" required=""
            pattern=".{3,50}" />
        </div>
        <div>
          <button type="submit" class="btn btn-default submit" style="width: 50%;">Login</button>
        </div>
        <div class="separator">
          <div class="clearfix"></div>
          <br />
          <!-- <?= $this->session->flashdata("msg") ?> -->
          <div>
            <h1><img src="<?= base_url('assets/img/logo_icon.png') ?>" alt="logo" height="15%" width="15%"> PLN Icon Plus</h1>
            <p><a id="a" href="#">PLN Icon Plus©2024 All Rights Reserved.</a></p>
          </div>
        </div>
      </form>
    </section>
  </div>
  <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#username").focus();

      <?php
      $msg = $this->session->flashdata("msg");
      if ($msg) { ?>
        Swal.fire(
          "<?= ucfirst($msg[0]) ?>",
          "<?= $msg[1] ?>",
          "<?= $msg[0] ?>"
        )
      <?php } ?>
    });
  </script>
</body>

</html>
