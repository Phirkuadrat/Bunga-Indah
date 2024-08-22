<?php

include('../../connection/connection.php');

$id = $_GET['id'];

$query = "SELECT gambar FROM product WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($gambar);
$stmt->fetch();
$stmt->close();

$query = "DELETE FROM product WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    $target_dir = "../../assets/product/";

    if (file_exists($target_dir . $gambar)) {
        unlink($target_dir . $gambar);
    }

    header("Location: ../tabel_product.php?success=Product Berhasil Dihapus!");
    exit();
} else {
    header("Location: ../tabel_product.php?failed=Product Gagal Dihapus!");
    exit();
}

$stmt->close();
$conn->close();

?>
