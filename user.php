<?php session_start(); ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>
        标注系统
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]>
    <script src="assets/js/ie/html5shiv.js">
    </script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ie8.css" />
    <![endif]-->
</head>

<body>
<!-- Wrapper -->
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <!-- Logo -->
            <a href="user.php" class="logo">
            <span class="symbol">
              <img src="images/logo.svg" alt="" />
            </span>
            <span class="title">
              标注系统
            </span>
            </a>
            <?php if(isset($_SESSION['user'])): ?>
            <div id="user" data=<?php echo $_SESSION['user']; ?> style="position: absolute; right: 225px;top: 58px; width: 150px">
            </div>
            <div style="position: absolute; right: 150px; top: 58px; width: 100px">
                <a id='logout-a' href="" >注销</a>
            </div>
            <?php endif; ?>
            <!-- Nav -->
        </div>
    </header>

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

            <section class="tiles">

<!--                <div style="display:none">-->
<!--                    <div style="position: absolute; right: 50%; top: 200px">-->
<!--                        <h1><button class="enter-btn" data='index' id="enter-mark-btn">标注入口</button> </h1>-->
<!--                    </div>-->
<!--                    <div style="position: absolute; right: 50%; top: 350px">-->
<!--                        <h1><button class="enter-btn" data='filter' id="enter-filter-btn">筛选入口</button> </h1>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div style="position: absolute; right: 50%; top: 350px">-->
<!--                    <h1><button class="enter-btn" data='clean' id="enter-clean-btn">清洗入口</button> </h1>-->
<!--                </div>-->
                <div id="user_help">
                    <div id="user_info">
                        <div style="position: absolute; left: 50px; top: 100px; ">
                            标注人员信息：
                        </div>

                        <div style="position: absolute; left: 100px; top: 200px">
                            10000
                        </div>
                    </div>

                    <div id="user_border1"></div>

                    <div id="user_operate">
                        <div id="user_status">
                            <div id="finish" style="position: relative; left: 100px;top: 60px; width: 200px">
                            </div>
                            <div id="unfinish" style="position: relative; left: 100px;top: 120px; width: 200px">
                            </div>
                        </div>
                        <div id="user_border2"></div>
                        <div style="width: 400px; height: 150px;" >
                            <div style="position: relative; left: 100px; top: 20px">
                                <h1><button class="enter-btn" data='clean' id="enter-clean-btn">清洗入口</button> </h1>
                            </div>
                        </div>
                    </div>
                </div>


            </section>

        </div>

    </div>
</div>
<?php endif; ?>
<!-- Scripts -->
<script src="assets/js/jquery.min.js"> </script>
<script src="assets/js/jquery.Jcrop.js"> </script>
<script src="assets/js/skel.min.js"> </script>
<script src="assets/js/util.js"> </script>
<!--[if lte IE 8]>
<script src="assets/js/ie/respond.min.js"> </script>
<![endif]-->
<script src="assets/js/main.js"> </script>

</body>

</html>
