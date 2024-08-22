<?php
    include('../connection/connection.php');
    session_start(); 

    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $sql = "SELECT * FROM user WHERE (username = ? OR email = ? ) AND password = ?";
        $stmt = $conn->prepare($sql); 
        if ($stmt) {
            $stmt->bind_param("sss", $username, $username, $password); 
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($db_id, $db_nama, $db_username, $db_email, $db_password, $db_order);
                $stmt->fetch(); 
                $_SESSION['id'] = $db_id;
                $_SESSION['nama'] = $db_nama;
                $_SESSION['username'] = $db_username;
                $_SESSION['email'] = $db_email;
                $_SESSION['order'] = $db_order;
                $_SESSION['logged_in'] = true;
                header("Location: ../home_page.php?success=Berhasil Login");
                exit();
            } else {
                header("Location: ../login_page.php?failed=Email Atau Password salah!");
                exit();
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
        $conn->close(); 
    }
?>
