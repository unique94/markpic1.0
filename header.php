    <!-- Header -->
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
            <nav>
                <ul>
                    <li>
                        <a href="#menu">
                            Menu
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Menu -->
    <nav id="menu">
        <h2>
            菜单
        </h2>
        <ul>
            <li>
                <a href="user.php">
                    首页面
                </a>
            </li>
        </ul>
    </nav>
