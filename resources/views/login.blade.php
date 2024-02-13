<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>Login - Satpol PP</title>
  <!-- Favicons -->
  <link href="/img/satpolpp/fav.png" rel="icon">
  <link href="/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="/css/style.css" rel="stylesheet">
  <link href="/css/style-responsive.css" rel="stylesheet">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<!-- MAIN CONTENT -->
<div id="login-page">
  
    <div class="container">
      <form class="form-login" id="form" onsubmit="return false">
      <?= csrf_field(); ?>
        <h2 class="form-login-heading"><img src="img/satpolpp/logo4.png" alt="" width="270px"></h2>
        <br><h4 class="text-center">LOGIN</h4>
        <div class="login-wrap">
          <input type="text" name="username" class="form-control" placeholder="Username" id="username" autofocus><span class="glyphicon glyphicon-user form-control-feedback"></span>
          <br>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          <br>
          <button class="btn btn-login btn-block btn-success" name="login"  type="submit"><i class="fa fa-lock"></i> MASUK</button>
        </div>
      </form>
    </div>
  </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/lib/jquery/jquery.min.js"></script>
    <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
    <script>
      $.backstretch("img/loginBg.jpg", {
        speed: 500
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
      $(document).ready(function() {

        $(".btn-login").click(function() {

          var username = $("#username").val();
          var password = $("#password").val();

          if (username.length == "") {

            Swal.fire({
              type: 'warning',
              title: 'Oops...',
              text: 'Username Wajib Diisi !'
            });

          } else if (password.length == "") {

            Swal.fire({
              type: 'warning',
              title: 'Oops...',
              text: 'Password Wajib Diisi !'
            });

          } else {

            $.ajax({

              url: "<?php echo base_url() ?>/login/auth",
              type: "POST",
              data:$('#form').serialize(),

              success: function(response) {

                if (response == "success") {

                  Swal.fire({
                      type: 'success',
                      title: 'Login Berhasil!',
                      text: 'Anda akan di arahkan dalam 3 Detik',
                      timer: 3000,
                      showCancelButton: false,
                      showConfirmButton: false
                    })
                    .then(function() {
                      window.location.href = "<?php echo base_url() ?>index.php/dashboard";
                    });

                } else {

                  Swal.fire({
                    type: 'error',
                    title: 'Login Gagal!',
                    text: 'silahkan coba lagi!'
                  });


                }

                console.log(response);

              },

              error: function(response) {

                Swal.fire({
                  type: 'error',
                  title: 'Opps!',
                  text: 'server error!'
                });

                console.log(response);

              }

            });

          }

        });

      });
    </script>

    </body>

</html>