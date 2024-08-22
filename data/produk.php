<?php
include('./connection/connection.php');

$query = "SELECT * FROM product where stok != 0";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$product = [];
while ($row = $result->fetch_assoc()) {
    $product[] = $row;
}
$stmt->close();
$conn->close();
?>
