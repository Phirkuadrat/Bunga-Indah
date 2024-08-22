<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('location: home_page.php');
    exit;
}
include('header/header.php');
include('connection/connection.php');

// Ambil id_user dari sesi
$id_user = $_SESSION['id'];

// Query untuk mendapatkan data pesanan
$query =
    "SELECT 
    orders.id AS order_id, 
    product.id AS product_id,
    orders.*, 
    product.*
FROM 
    orders 
INNER JOIN 
    product 
ON 
    product.id = orders.id_product
    WHERE orders.id_user = ?
    ORDER BY orders.tanggal_order DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

function formatHarga($harga)
{
    return number_format($harga, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <style>
        .order-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!-- Content -->
    <section class="container myorder">
        <?php
        $currentDate = "";
        foreach ($orders as $order) {
            $orderDate = date('Y-m-d', strtotime($order['tanggal_order']));
            if ($currentDate !== $orderDate) {
                if ($currentDate !== "") {
                    echo '<hr>';
                }
                echo '<h4 class="mt-5 mb-3">' . date('d M Y', strtotime($order['tanggal_order'])) . '</h4>';
                $currentDate = $orderDate;
            }
        ?>
            <div class="row mb-3 mt-3">
                <div class="col-md-2">
                    <img src="/assets/product/<?php echo $order['gambar']; ?>" class="img-fluid order-image" alt="Gambar <?php echo $order['nama']; ?>">
                </div>
                <div class="col-md-6">
                    <h5><?php echo $order['nama']; ?></h5>
                    <p>Alamat: <?php echo $order['alamat']; ?></p>
                    <p>Total Bayar: Rp <?php echo formatHarga($order['total_harga']); ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="track_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-info">Track</a>
                    <a href="admin/order_details.php?id=<?php echo $order['order_id']; ?>" class="btn btn-success">Invoice</a>
                    <a href="order_page.php?id=<?php echo $order['product_id']; ?>" class="btn btn-primary">Beli Lagi</a>
                </div>
            </div>
            <hr>
        <?php } ?>
    </section>
    <!-- Content End -->

    <!-- Notifikasi -->
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