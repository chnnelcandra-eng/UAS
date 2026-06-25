<?php
include 'koneksi.php';
$kodepb = $_POST['kodepb'];
$kodepb = mysqli_real_escape_string($conn, $kodepb);

$header = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM masterpembelian WHERE kodepb='$kodepb'"));
$detail = [];
$res = mysqli_query($conn, "SELECT * FROM detailpembelian WHERE kodepb='$kodepb'");
while ($row = mysqli_fetch_assoc($res)) $detail[] = $row;

echo json_encode(['header' => $header, 'detail' => $detail]);
?>