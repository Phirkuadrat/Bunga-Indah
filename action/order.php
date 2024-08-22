<?php
session_start();
include('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    $tanggal_order = $_POST['tanggal_order'];
    $quantity = $_POST['kuantitas'];
    $diskon = $_POST['diskon'];
    $totalHarga = $_POST['konfirmasiTotalHarga'];
    $alamat = $_POST['konfirmasiAlamat'];
    $pengirim = $_POST['konfirmasiPengirim'];
    $penerima = $_POST['konfirmasiPenerima'];
    $email = $_POST['konfirmasiEmail'];
    $noHP = $_POST['konfirmasiNomor'];
    $kurir = $_POST['konfirmasiKurir'];

    // Insert into orders table
    $query = "INSERT INTO orders (id_user, id_product, tanggal_order, kuantitas, diskon, total_harga, alamat, nama_pengirim, nama_penerima, email, nomor_telepon, ekspedisi) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisiiissssss", $id_user, $id_product, $tanggal_order, $quantity, $diskon, $totalHarga, $alamat, $pengirim, $penerima, $email, $noHP, $kurir);

    if ($stmt->execute()) {
        // Update user's order count
        $update_query = "UPDATE user SET `order` = `order` + 1 WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $id_user);
        $update_stmt->execute();
        $update_stmt->close();

        // Update product stock
        $stok_query = "UPDATE product SET stok = stok - ? WHERE id = ?";
        $stok_stmt = $conn->prepare($stok_query);
        $stok_stmt->bind_param("ii", $quantity, $id_product);
        $stok_stmt->execute();
        $stok_stmt->close();

        // Redirect with success message
        header("Location: ../home_page.php?success=Berhasil Melakukan Order");
    } else {
        // Redirect with failure message
        header("Location: ../home_page.php?failed=Gagal Melakukan Order");
    }
    $stmt->close();
    $conn->close();
}
?>
