<?php
session_start();
include('data/produk.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-1/assets/css/hero-1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript">
        $(window).on('scroll', function() {
            if ($(window).scrollTop()) {
                $('nav').addClass('black');
                $('.logo img').attr('src', 'assets/logo2.png');
            } else {
                $('nav').removeClass('black');
                $('.logo img').attr('src', 'assets/logo3.png');
            }
        });
        $(document).ready(function() {
            $('.menu h4').click(function() {
                $("nav ul").toggleClass("active")
            })
        })
    </script>
</head>

<body>

    <!-- Navbar -->
    <nav>
        <div class="logo">
            <a href="#">
                <img src="assets/logo3.png" alt="logo" />
            </a>
        </div>
        <ul>
            <li><a href="#promo">Promo</a></li>
            <li><a href="#product">Product</a></li>
            <li><a href="#sosmed">Social Media</a></li>
            <li>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                    <a href="myOrder_page.php">My Order</a>
                    <a href="/action/logout.php">Logout</a>
                <?php } else { ?>
                    <a href="login_page.php">Login</a>
                <?php } ?>
            </li>
            <li class="ml-5">

            </li>
        </ul>
    </nav>
    <!-- Navbar End -->

    <!-- Hero -->
    <section class="bsb-hero-1 px-3 hero-img">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-11 col-lg-9 col-xl-7 col-xxl-6 text-center text-white">
                    <h2 class="display-3 fw-bold mb-3">Indah Bunga</h2>
                    <p class="lead mb-5">"Bunga untuk Setiap Momen yang Berharga" <br>Kirimkan Kebahagiaan dengan Rangkaian Bunga Eksklusif</p>
                </div>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="#product">
                        <button type="button" class="btn bsb-btn-xl btn-light gap-3">
                            Pesan Sekarang
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero End -->

    <!-- Promo -->
    <section class="mt-5" id="promo">
        <div class="container">
            <div class="row justify-content-center align-self-center text-center">
                <div class="col-12 mb-5">
                    <h4>
                        Promo
                    </h4>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/promo/promo diskon 10%.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/promo/2.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/promo/3.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- Promo End -->

    <!-- Product -->
    <section class="product mt-5" id="product">
        <div class="container">
            <div class="row justify-content-center align-self-center text-center">
                <div class="col-12 mt-5">
                    <h4>
                        Product
                    </h4>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="row mt-4">
                <?php foreach ($product as $row) { ?>
                    <div class="col-md-4 mt-2 mb-5">
                        <div class="content">
                            <?php if (isset($_SESSION['logged_in'])) { ?>
                                <a href="order_page.php?id=<?php echo $row['id'] ?>">
                                <?php } else { ?>
                                    <!-- masuk ke modal -->
                                    <a href="#" onclick="confirmGuest(<?php echo $row['id'] ?>)">
                                <?php } ?>
                                    <div class="content-overlay"></div>
                                    <img class="content-image" src="assets/product/<?php echo $row['gambar'] ?>" alt="Gambar <?php echo $row['nama'] ?>">
                                    <div class="content-details fadeIn-bottom">
                                        <h3 class="content-title"><?php echo $row['nama'] ?></h3>
                                    </div>
                                    </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Product End -->
    <script>
        function confirmGuest(productId) {
            Swal.fire({
                title: 'Lanjutkan Tanpa Akun?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'blue',
                cancelButtonText: 'Login',
                confirmButtonText: 'Lanjutkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'order_page.php?id=' + productId;
                }
            })
        }
    </script>
    <!-- Notifikasi Guest -->

    <!-- Notifikasi Guest End -->

    <!-- Social Media -->
    <section class="social-media mt-5 mb-5" id="sosmed">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic d-flex flex-wrap">
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/1.jpg');"></div>
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/2.jpg');"></div>
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/3.jpg');"></div>
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/4.jpg');"></div>
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/5.jpg');"></div>
                        <div class="instagram__pic__item" style="background-image: url('assets/sosial media/6.jpg');"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sosmed__text">
                        <h2>Social Media</h2>
                        <p>"Ingin melihat bagaimana bunga kami membawa senyuman? Ikuti perjalanan kami di Instagram, Twitter dan Facebook nikmati galeri penuh warna-warni keindahan!"</p>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="bi bi-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="bi bi-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="bi bi-instagram"></i></a></li>
                        </ul>
                        <h3>#KeindahanBungaIndah</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Social Media End -->



    <!-- Notfikasi -->
    <?php if (isset($_GET["success"])) { ?>
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "<?php echo $_GET["success"] ?>",
                icon: "success"
            });
        </script>
    <?php } ?>
    <!-- Notifikasi End -->

</body>

</html>