<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: home_page.php');
    exit;
}
include('../connection/connection.php');

// Ambil id_user dari sesi
$id = $_GET['id'];

// Query untuk mendapatkan data pesanan
$query = "SELECT o.*, p.nama, p.gambar 
          FROM orders o
          JOIN product p ON o.id_product = p.id
          WHERE o.id = ?
          ORDER BY o.tanggal_order DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

function formatHarga($harga) {
    return number_format($harga, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <section class="container my-5">
        <h2 class="mb-4">Order Details</h2>
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
                <div class="col-md-10">
                    <h5><?php echo $order['nama']; ?></h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Order ID</th>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td><?php echo htmlspecialchars($order['nama']); ?></td>
                        </tr>
                        <tr>
                            <th>Sender Name</th>
                            <td><?php echo htmlspecialchars($order['nama_pengirim']); ?></td>
                        </tr>
                        <tr>
                            <th>Recipient Name</th>
                            <td><?php echo htmlspecialchars($order['nama_penerima']); ?></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>Rp. <?php echo formatHarga($order['total_harga']); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo htmlspecialchars($order['alamat']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo htmlspecialchars($order['nomor_telepon']); ?></td>
                        </tr>
                        <tr>
                            <th>Expedition</th>
                            <td><?php echo htmlspecialchars($order['ekspedisi']); ?></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td><?php echo htmlspecialchars($order['kuantitas']); ?></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td><?php echo htmlspecialchars($order['diskon']); ?></td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td><?php echo htmlspecialchars($order['tanggal_order']); ?></td>
                        </tr>
                    </table>
                    <a href="track_order.php?id=<?php echo $order['id']; ?>" class="btn btn-info">Cetak</a>
                </div>
            </div>
        <?php } ?>
    </section>
    <!-- Content End -->
</body>
</html>
