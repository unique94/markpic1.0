<?php session_start(); ?>
<!DOCTYPE HTML>
<!-- Phantom by HTML5 UP html5up.net | @n33co Free for personal and commercial
use under the CCA 3.0 license (html5up.net/license) -->
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <title>
      Phantom by HTML5 UP
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]>
      <script src="assets/js/ie/html5shiv.js">
      </script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 9]>
      <link rel="stylesheet" href="assets/css/ie9.css" />
    <![endif]-->
    <!--[if lte IE 8]>
      <link rel="stylesheet" href="assets/css/ie8.css" />
    <![endif]-->
  </head>

  <body>
    <div id="wrapper">
      <?php include('header.php');?>
      <!-- Main -->
      <div id="main">
        <div class="inner">

          <?php if(!isset($_SESSION['user'])): ?>
            <div id="grid_page">
              <ul>
                <li ><a id="return-login" href="login.php">请登录</a></li>
              </ul>
            </div>
          <?php else: ?>
          <div id="gotobottom"><img src="images/scrolldown.png"></div>
          <header>
            <h1>
              筛选
            </h1>
            <h2 id="mark-name">
             筛选目录: <?php echo $_SESSION['dirName'];?>
            </h2>
          </header>
          <section class="tiles">

            <article class='tmpart'>
              <img src="" id="" alt="" />

            </article>

            <br/>

          </section>

          <?php include("foot.php");?>
        </div>

      </div>
    </div>
    <?php endif; ?>
    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"> </script>
    <script src="assets/js/skel.min.js"> </script>
    <script src="assets/js/util.js"> </script>
    <!--[if lte IE 8]>
      <script src="assets/js/ie/respond.min.js"> </script>
    <![endif]-->
    <script src="assets/js/main.js"> </script>
    <?php if(isset($_SESSION['user'])): ?>
    <script src="assets/js/filter.js"> </script>
    <script src="assets/js/page.js"> </script>
    <script src="assets/js/topbottom.js"></script>
    <?php endif; ?>
  </body>

</html>
