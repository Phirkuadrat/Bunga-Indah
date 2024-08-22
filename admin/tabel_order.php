<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('location: login_admin.php');
    exit;
}
include('../connection/connection.php');

$query_orders = "SELECT 
    orders.id AS order_id, 
    product.id AS product_id,
    orders.*, 
    product.*
FROM 
    orders 
INNER JOIN 
    product 
ON 
    product.id = orders.id_product;";
$result_orders = $conn->query($query_orders);
$orders = $result_orders->fetch_all(MYSQLI_ASSOC);

$query_products = "SELECT * FROM product WHERE stok != 0";
$stmt = $conn->prepare($query_products);
$stmt->execute();
$result_products = $stmt->get_result();

$product = [];
while ($row = $result_products->fetch_assoc()) {
    $product[] = $row;
}

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
    <title>Dashboard - Bunga Indah Admin Dashboard</title>
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a href="index.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="tabel_order.php" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>Order</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="tabel_user.php" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="tabel_product.php" class='sidebar-link'>
                                <i class="bi bi-bag"></i>
                                <span>Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="logout.php" class='sidebar-link'>
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Tabel User</h3>
                <div class="add-button">
                    <button type="button" class="btn icon btn-primary" data-bs-toggle="modal" data-bs-target="#modalOrder"><i class="bi bi-pencil">Add Product</i></button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-24">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Sender</th>
                                            <th>Recipient</th>
                                            <th>Message</th>
                                            <th>Address</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order) { ?>
                                            <tr>
                                                <td><?= $order['nama'] ?></td>
                                                <td><?= $order['nama_pengirim'] ?></td>
                                                <td><?= $order['nama_penerima'] ?></td>
                                                <td>Rp.<?= formatHarga($order['total_harga']) ?></td>
                                                <td><?= $order['alamat'] ?></td>
                                                <td>
                                                    <a href="order_details.php?id= <?php echo $order['order_id'] ?>" class="btn btn-info">Detail</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; Bunga Indah</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Add Order -->
    <div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="action/add_order.php" method="POST"> <!-- removed the backslash after orderForm -->
                        <div class="mb-3">
                            <label for="sender" class="form-label">Sender</label>
                            <input type="text" class="form-control" id="sender" name="konfirmasiPengirim" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient" class="form-label">Recipient</label>
                            <input type="text" class="form-control" id="recipient" name="konfirmasiPenerima" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="address" class="form-control" name="konfirmasiAlamat" required />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="konfirmasiEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" id="nomor" name="konfirmasiNomor" required>
                        </div>
                        <div class="mb-3">
                            <label for="kurir" class="form-label">Expedition</label>
                            <select class="form-select" id="kurir" name="konfirmasiKurir" required>
                                <option value="JNE">JNE</option>
                                <option value="J&T Express">J&T Express</option>
                                <option value="Tiki">Tiki</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_product" class="form-label">Product</label>
                            <select class="form-select" id="id_product" name="id_product" required>
                                <?php foreach ($product as $p) : ?>
                                    <option value="<?= $p['id'] ?>" data-price="<?= $p['harga'] ?>"><?= $p['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="diskon" class="form-label">Discount Code</label>
                            <input type="text" class="form-control" id="diskon" name="diskon" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Price</label>
                            <input type="text" class="form-control" id="konfirmasiTotalHarga" name="konfirmasiTotalHarga" readonly>
                        </div>
                        <input type="hidden" name="tanggal_order" value="<?php echo date('Y-m-d'); ?>">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Order</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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


    <script src="./assets/static/js/components/dark.js"></script>
    <script src="./assets/compiled/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectProduct = document.getElementById('id_product');
            const inputQuantity = document.getElementById('kuantitas');
            const inputDiscount = document.getElementById('diskon');
            const totalHarga = document.getElementById('konfirmasiTotalHarga');

            function calculateTotal() {
                const selectedProduct = selectProduct.options[selectProduct.selectedIndex];
                const price = parseFloat(selectedProduct.getAttribute('data-price'));
                const quantity = parseInt(inputQuantity.value);
                const discount = parseFloat(inputDiscount.value);

                if (!isNaN(price) && !isNaN(quantity) && !isNaN(discount)) {
                    const total = (price * quantity) - ((price * quantity) * (discount / 100));
                    totalHarga.value = total;
                } else {
                    totalHarga.value = 'Rp 0';
                }
            }

            selectProduct.addEventListener('change', calculateTotal);
            inputQuantity.addEventListener('input', calculateTotal);
            inputDiscount.addEventListener('input', calculateTotal);
        });
    </script>

</body>

</html>