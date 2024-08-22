<?php
include('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $sql = "SELECT email FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("Location: ../register_page.php?failed=Email Sudah Digunakan! Gagal Membuat Akun");
            $stmt->close();
            exit();
        } else {
            $stmt->close();
            $sql = "INSERT INTO user (nama, username, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssss", $nama, $username,  $email, $password);
                if ($stmt->execute()) {
                    header("Location: ../login_page.php?success=Berhasil Membuat Akun");
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

