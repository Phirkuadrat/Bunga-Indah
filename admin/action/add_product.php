<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../connection/connection.php');

    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../../assets/product/";
    $target_file = $target_dir . basename($gambar);

    $check = getimagesize($_FILES['gambar']['tmp_name']);
    if($check !== false) {
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $stmt = $conn->prepare("INSERT INTO product (nama, harga, deskripsi, gambar, stok) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sissi", $nama, $harga, $deskripsi, $gambar, $stok);

            if ($stmt->execute() === TRUE) {
                header("Location: ../tabel_product.php?success=product Berhasil Ditambahkan!");
                exit();
            } else {
                header("Location: ../tabel_product.php?failed=product Gagal Ditambahkan!");
                exit();
            }
            $stmt->close();
        } else {
            header("Location: ../tabel_product.php?failed=Gagal mengunggah gambar!");
            exit();
        }
    } else {
        header("Location: ../tabel_product.php?failed=File bukan gambar!");
        exit();
    }
    $conn->close();
}
?>
