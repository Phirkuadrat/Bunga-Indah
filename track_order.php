<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: home_page.php');
    exit;
}
include('connection/connection.php');

// Ambil id dari query string
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
$order = $result->fetch_assoc();

if (!$order) {
    echo "Order not found.";
    exit;
}

function formatHarga($harga) {
    return number_format($harga, 0, ',', '.');
}

$orderDate = date('d, F Y', strtotime($order['tanggal_order']));
$trackingStatus = $order['status'] ?? 'PLACED'; // Status default jika tidak ada

// Menentukan status tracking
$steps = ['PLACED', 'SHIPPED', 'DELIVERED'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        #progressbar-1 {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
        }
        #progressbar-1 li {
            width: 33%;
            position: relative;
        }
        #progressbar-1 li::before {
            content: "";
            width: 20px;
            height: 20px;
            background: #ddd;
            border-radius: 50%;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 50%;
            z-index: 1;
        }
        #progressbar-1 li.active::before {
            background: #007bff;
            color: #fff;
        }
        #progressbar-1 li span {
            position: absolute;
            top: 40px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <section class="vh-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-10 col-lg-8 col-xl-6">
                    <div class="card card-stepper" style="border-radius: 16px;">
                        <div class="card-header p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-2"> Order ID <span class="fw-bold text-body"><?php echo htmlspecialchars($order['id']); ?></span></p>
                                    <p class="text-muted mb-0"> Place On <span class="fw-bold text-body"><?php echo $orderDate; ?></span> </p>
                                </div>
                                <div>
                                    <h6 class="mb-0"> <a href="admin/order_details.php?id=<?php echo htmlspecialchars($order['id']); ?>">View Details</a> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-row mb-4 pb-2">
                                <div class="flex-fill">
                                    <h5 class="bold"><?php echo htmlspecialchars($order['nama']); ?></h5>
                                    <p class="text-muted"> Qt: <?php echo htmlspecialchars($order['kuantitas']); ?> item</p>
                                    <h4 class="mb-3"> Rp. <?php echo formatHarga($order['total_harga']); ?> <span class="small text-muted"> via (COD) </span></h4>
                                    <p class="text-muted">Tracking Status on: <span class="text-body"><?php echo date('H:i', strtotime($order['tanggal_order'])); ?>, Today</span></p>
                                </div>
                                <div>
                                    <img class="align-self-center img-fluid order-image"
                                        src="/assets/product/<?php echo htmlspecialchars($order['gambar']); ?>" width="250">
                                </div>
                            </div>
                            <ul id="progressbar-1" class="mx-0 mt-0 mb-5 px-0 pt-0 pb-4">
                                <?php foreach ($steps as $index => $step): ?>
                                    <li class="<?php echo ($trackingStatus == $step) ? 'active' : 'text-muted'; ?>" id="step<?php echo $index + 1; ?>">
                                        <span><?php echo $step; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-footer p-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
