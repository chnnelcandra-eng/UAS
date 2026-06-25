<?php
include "koneksi.php";
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM items ORDER BY kode ASC");
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode($items);
?>