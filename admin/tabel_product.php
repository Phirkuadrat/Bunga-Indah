<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('location: login_admin.php');
    exit;
}
include('../connection/connection.php');

$query_users = "SELECT * FROM product";
$result_users = $conn->query($query_users);
$products = $result_users->fetch_all(MYSQLI_ASSOC);

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
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
                        <li class="sidebar-item">
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
                        <li class="sidebar-item active">
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
                <h3>Tabel Product</h3>
                <div class="add-button">
                    <button type="button" class="btn icon btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi bi-pencil">Add Product</i></button>
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
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) : ?>
                                            <tr>
                                                <td class="col-auto">
                                                    <img src="../assets/product/<?php echo $product['gambar']; ?>" alt="<?php echo $product['nama']; ?>" class="product-image">
                                                </td>
                                                <td class="col-3">
                                                    <p class="mb-0"><?php echo $product['nama']; ?></p>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Rp.<?php echo formatHarga($product['harga']) ?></p>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0"><?php echo $product['stok'] ?></p>
                                                </td>
                                                <td class="col-auto">
                                                    <button type="button" class="btn icon icon-left btn-primary edit-product-btn" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="<?php echo $product['id']; ?>" data-nama="<?php echo $product['nama']; ?>" data-harga="<?php echo $product['harga']; ?>" data-stok="<?php echo $product['stok']; ?>" data-deskripsi="<?php echo $product['deskripsi']; ?>" data-gambar="<?php echo $product['gambar']; ?>">
                                                        <i data-feather="edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn icon icon-left btn-danger" onclick="confirmDelete(<?php echo $product['id']; ?>)"><i data-feather="edit"></i> Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
    </div>
    </div>

    <!-- Modal Add Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="action/add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Description</label>
                            <textarea class="form-control" id="productDesc" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="productImage" name="gambar" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="productStock" name="stok" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="action/edit_product.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="editProductId" name="id">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDesc" class="form-label">Product Description</label>
                            <textarea class="form-control" id="editProductDesc" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Product Image</label> <br>
                            <img id="editProductImagePreview" src="" alt="Product Image" style="width: 100px; height: 100px; object-fit: cover; margin-top: 10px;">
                            <input type="file" class="form-control" id="editProductImage" name="gambar">
                        </div>

                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editProductPrice" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editProductStock" name="stok" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'action/delete_product.php?id=' + productId;
                }
            })
        }

        document.addEventListener("DOMContentLoaded", function() {
            var editButtons = document.querySelectorAll('.edit-product-btn');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var name = this.getAttribute('data-nama');
                    var desc = this.getAttribute('data-deskripsi');
                    var image = this.getAttribute('data-gambar');
                    var price = this.getAttribute('data-harga');
                    var stock = this.getAttribute('data-stok');

                    document.getElementById('editProductId').value = id;
                    document.getElementById('editProductName').value = name;
                    document.getElementById('editProductDesc').value = desc;
                    document.getElementById('editProductImagePreview').src = "../assets/product/" + image;
                    document.getElementById('editProductPrice').value = price;
                    document.getElementById('editProductStock').value = stock;
                });
            });
        });
    </script>

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