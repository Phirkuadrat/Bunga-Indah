<?php
session_start();
include('header/header.php');
include('connection/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM product WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    }
}

function formatHarga($harga)
{
    return number_format($harga, 0, ',', '.');
}

if (isset($_SESSION['order'])) {
    $order = $_SESSION['order'];
    $idUser = $_SESSION['id'];
} else {
    $order = 0;
    $idUser = 0;
    $_SESSION['id'] = 0;
    $_SESSION['logged_in'] = true;
}

$hargaSatuan = $row['harga'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-1/assets/css/hero-1.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>

<body>
    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="/assets/product/<?php echo $row['gambar']; ?>" alt="..." /></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder"><?php echo $row['nama']; ?></h1>
                    <div class="fs-5 mb-3">
                        <span>Rp <?php echo formatHarga($hargaSatuan) ?></span>
                    </div>
                    <p class="lead"><?php echo $row['deskripsi'] ?></p>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" min="1" style="max-width: 5rem" onchange="updateTotal()">
                        <button class="btn btn-outline-dark flex-shrink-0" type="button" data-bs-toggle="modal" data-bs-target="#modalOrder">
                            <i class="bi-cart-fill me-1"></i>
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Order -->
    <div class="modal fade" id="modalOrder" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Formulir Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="orderForm">
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col">
                                <div>
                                    <label class="form-label" for="pengirim">Nama Pengirim</label>
                                    <input type="text" id="pengirim" class="form-control" name="pengirim" required />
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <label class="form-label" for="penerima">Nama Penerima</label>
                                    <input type="text" id="penerima" class="form-control" name="penerima" required />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Alamat Pengiriman</label>
                            <input type="text" id="address" class="form-control" name="alamat" required />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control" id="nomor" name="nomor" required>
                        </div>
                        <div class="mb-3">
                            <label for="kupon" class="form-label">Kupon Diskon</label>
                            <select class="form-select" id="kupon">
                                <option value="0">Tidak ada</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kurir" class="form-label">Ekspedisi Pengiriman</label>
                            <select class="form-select" id="kurir" name="kurir" required>
                                <option value="JNE">JNE</option>
                                <option value="J&T Express">J&T Express</option>
                                <option value="Tiki">Tiki</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <label for="harga" class="form-label">Total Harga</label>
                        <p id="totalHargaModal" class="mb-0"><?php echo formatHarga($hargaSatuan); ?></p>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary">Tambah Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="modalKonfirmasi" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalKonfirmasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalKonfirmasiLabel">Konfirmasi Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="action/order.php" method="POST">
                    <div class="modal-body">
                        <p>Pengirim: <span id="konfirmasiPengirim"></span></p>
                        <p>Penerima: <span id="konfirmasiPenerima"></span></p>
                        <p>Alamat Pengiriman: <span id="konfirmasiAlamat"></span></p>
                        <p>Email: <span id="konfirmasiEmail"></span></p>
                        <p>Nomor Telepon: <span id="konfirmasiNomor"></span></p>
                        <p>Ekspedisi Pengiriman: <span id="konfirmasiKurir"></span></p>
                        <p>Kuantitas: <span id="konfirmasiKuantitas"></span></p>
                        <p>Diskon: <span id="konfirmasiKupon"></span></p>
                        <p>Total Harga: Rp. <span id="konfirmasiTotalHarga"></span></p>
                        <input type="hidden" id="konfirmasiKuantitasInput" name="kuantitas">
                        <input type="hidden" id="konfirmasiKuponInput" name="diskon">
                        <input type="hidden" id="konfirmasiTotalHargaInput" name="konfirmasiTotalHarga">
                        <input type="hidden" id="konfirmasiAlamatInput" name="konfirmasiAlamat">
                        <input type="hidden" id="konfirmasiPengirimInput" name="konfirmasiPengirim">
                        <input type="hidden" id="konfirmasiPenerimaInput" name="konfirmasiPenerima">
                        <input type="hidden" id="konfirmasiEmailInput" name="konfirmasiEmail">
                        <input type="hidden" id="konfirmasiNomorInput" name="konfirmasiNomor">
                        <input type="hidden" id="konfirmasiKurirInput" name="konfirmasiKurir">
                        <input type="hidden" name="tanggal_order" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="id_user" value="<?php echo $idUser; ?>">
                        <input type="hidden" name="id_product" value="<?php echo $id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi dan Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const hargaSatuan = <?php echo $hargaSatuan; ?>;
        const order = <?php echo $order; ?>;

        function updateTotal() {
            const jumlah = document.getElementById('inputQuantity').value;
            const kupon = document.getElementById('kupon').value;

            let totalHarga = hargaSatuan * jumlah;

            if ((totalHarga >= 1000000 || order > 3) && kupon > 0) {
                totalHarga -= totalHarga * (kupon / 100);
            }

            document.getElementById('totalHargaModal').innerText = totalHarga;
        }

        document.getElementById('inputQuantity').addEventListener('change', updateTotal);

        document.addEventListener('DOMContentLoaded', () => {
            const kuponSelect = document.getElementById('kupon');
            const jumlah = document.getElementById('inputQuantity').value;
            const totalHargaAwal = hargaSatuan * jumlah;

            if (totalHargaAwal >= 1000000) {
                const option = document.createElement('option');
                option.value = '5';
                option.text = 'Diskon 5%';
                kuponSelect.add(option);
            }

            if (order > 3) {
                const option = document.createElement('option');
                option.value = '10';
                option.text = 'Diskon 10%';
                kuponSelect.add(option);
            }
            updateTotal();
        });

        $('#modalOrder').on('shown.bs.modal', function() {
            const kuponSelect = document.getElementById('kupon');
            kuponSelect.innerHTML = '<option value="0">Tidak ada</option>';

            const jumlah = document.getElementById('inputQuantity').value;
            const totalHargaAwal = hargaSatuan * jumlah;

            if (totalHargaAwal >= 1000000) {
                const option = document.createElement('option');
                option.value = '5';
                option.text = 'Diskon 5%';
                kuponSelect.add(option);
            }

            if (order > 3) {
                const option = document.createElement('option');
                option.value = '10';
                option.text = 'Diskon 10%';
                kuponSelect.add(option);
            }

            updateTotal();
        });

        document.getElementById('kupon').addEventListener('change', updateTotal);

        function showConfirmationModal() {
            const form = document.getElementById('orderForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Mengisi data modal konfirmasi dengan nilai form order
            document.getElementById('konfirmasiPengirim').innerText = document.getElementById('pengirim').value;
            document.getElementById('konfirmasiPenerima').innerText = document.getElementById('penerima').value;
            document.getElementById('konfirmasiAlamat').innerText = document.getElementById('address').value;
            document.getElementById('konfirmasiEmail').innerText = document.getElementById('email').value;
            document.getElementById('konfirmasiNomor').innerText = document.getElementById('nomor').value;
            document.getElementById('konfirmasiKupon').innerText = document.getElementById('kupon').options[document.getElementById('kupon').selectedIndex].text;
            document.getElementById('konfirmasiKurir').innerText = document.getElementById('kurir').options[document.getElementById('kurir').selectedIndex].text;
            document.getElementById('konfirmasiKuantitas').innerText = document.getElementById('inputQuantity').value;
            document.getElementById('konfirmasiTotalHarga').innerText = document.getElementById('totalHargaModal').innerText;

            // Mengatur nilai input tersembunyi
            document.getElementById('konfirmasiPengirimInput').value = document.getElementById('pengirim').value;
            document.getElementById('konfirmasiPenerimaInput').value = document.getElementById('penerima').value;
            document.getElementById('konfirmasiAlamatInput').value = document.getElementById('address').value;
            document.getElementById('konfirmasiEmailInput').value = document.getElementById('email').value;
            document.getElementById('konfirmasiNomorInput').value = document.getElementById('nomor').value;
            document.getElementById('konfirmasiKuponInput').value = document.getElementById('kupon').value;
            document.getElementById('konfirmasiKurirInput').value = document.getElementById('kurir').value;
            document.getElementById('konfirmasiKuantitasInput').value = document.getElementById('inputQuantity').value;
            document.getElementById('konfirmasiTotalHargaInput').value = document.getElementById('totalHargaModal').innerText;

            // Menutup modal order
            const modalOrder = bootstrap.Modal.getInstance(document.getElementById('modalOrder'));
            if (modalOrder) {
                modalOrder.hide();
            }

            // Menampilkan modal konfirmasi
            const modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
            modalKonfirmasi.show();
        }
    </script>
</body>

</html>