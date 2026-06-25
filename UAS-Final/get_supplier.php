<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama_perusahaan ASC");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
?>