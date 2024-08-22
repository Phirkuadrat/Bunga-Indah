<nav class="custom-navbar">
    <div class="logo">
        <img src="/assets/logo2.png" alt="logo" />
    </div>
    <ul>
        <li><a href="home_page.php#promo">Promo</a></li>
        <li><a href="home_page.php#product">Product</a></li>
        <li><a href="home_page.php">Social Media</a></li>
        <li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                <a href="#">My Order</a>
                <a href="/action/logout.php">Logout</a>
            <?php } else { ?>
                <a href="login_page.php">Login</a>
            <?php } ?>
        </li>
        <li class="ml-5">

        </li>
    </ul>
</nav>