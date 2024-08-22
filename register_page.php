<?php
include('header/header.php');
if (isset($_SESSION['logged_in'])) {
    header('location: home_page.php');
    exit;
}
include('header/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
</head>

<body>
    <!-- Content -->
    <section class="p-3 p-md-4 p-xl-5 container-register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 conlog2">
                    <div class="p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h3>Register</h3>
                                </div>
                            </div>
                        </div>
                        <form action="action/register.php" method="POST">
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="username" class="form-control" name="nama" id="nama" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="username" class="form-control" name="username" id="username" required>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" value="" required>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" type="submit">Register now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-6 conlog">
                    <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5 text-white">
                        <h3 class="m-0">Welcome To Indah Bunga!</h3>
                        <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="/assets/logo3.png" width="245" height="80" alt="BootstrapBrain Logo">
                        <p class="mb-0">Have an account?<a href="login_page.php" class="text-decoration-none text-white"> Go to login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content End -->

    <!-- Notifikasi -->
    <?php if (isset($_GET["failed"])) { ?>
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "<?php echo $_GET["failed"] ?>",
                icon: "error"
            });
        </script>
    <?php } ?>
    <!-- Notifikasi End -->
</body>

</html>