<?php
include '../../connection/connection.php';

if (isset($_POST['id'], $_POST['nama'], $_POST['deskripsi'], $_POST['harga'], $_POST['stok'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    if ($_FILES['gambar']['size'] > 0) {
        $query = "SELECT gambar FROM product WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $old_image = $row['gambar'];
        
        $old_image_path = "../assets/product/" . $old_image;
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }
        
        $new_image_name = basename($_FILES['gambar']['name']);
        $new_image_path = "../assets/product/" . $new_image_name;
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $new_image_path)) {
            header("location: ../tabel_product.php?failed=Failed to upload image");
            exit();
        }
    } else {
        $query = "SELECT gambar FROM product WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $new_image_name = $row['gambar'];
    }
    
    $update_query = "UPDATE product SET nama = ?, deskripsi = ?, harga = ?, stok = ?, gambar = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssdisi', $nama, $deskripsi, $harga, $stok, $new_image_name, $id);
    $result = $stmt->execute();
    
    if ($result) {
        header("location: ../tabel_product.php?success=Product berhasil diubah");
        exit();
    } else {
        header("location: ../tabel_product.php?failed=Product gagal diubah");
        exit();
    }
} else {
    header("location: ../tabel_product.php?failed=Data tidak lengkap");
    exit();
}
?>
