<?php
session_start();
session_destroy();
header("Location: ../home_page.php?success=Berhasil Keluar");
exit();
?>