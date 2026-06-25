<?php
header('Content-Type: application/json');
include "koneksi.php";

$kodepj = $_POST['kodepj'];

$q1 = mysqli_query($conn, "SELECT * FROM masterpenjualan WHERE kodepj='$kodepj'");
$header = mysqli_fetch_assoc($q1);

$q2 = mysqli_query($conn, "
    SELECT d.*, i.nama, i.satuan
    FROM detailpenjualan d
    JOIN items i ON d.kode = i.kode
    WHERE d.kodepj='$kodepj'
");

$detail = [];
while ($d = mysqli_fetch_assoc($q2)) {
    $detail[] = $d;
}

echo json_encode([
    "header" => $header,
    "detail" => $detail
]);
?>