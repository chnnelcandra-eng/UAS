<?php
include "koneksi.php";

$kodepj       = $_POST['kodepj']       ?? '';
$tgl          = $_POST['tgl']          ?? '';
$customerName = $_POST['customerName'] ?? '';
$phoneNum     = $_POST['phoneNum']     ?? '';
$keterangan   = $_POST['ket']          ?? '';
$total        = $_POST['total']        ?? 0;
$diskon       = $_POST['diskon']       ?? 0;
$grandtotal   = $_POST['grandtotal']   ?? 0;
$bayar        = $_POST['bayar']        ?? 0; // tidak disimpan ke DB, cukup default 0

$datadetail = json_decode($_POST['detail'] ?? '[]');

// masterpenjualan: kodepj, tgl, customerName, phoneNum, keterangan, total, diskon, subtotal
$sql = "INSERT INTO masterpenjualan
    (kodepj, tgl, customerName, phoneNum, keterangan, total, diskon, subtotal)
    VALUES ('$kodepj','$tgl','$customerName','$phoneNum','$keterangan',$total,$diskon,$grandtotal)";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error header: " . $conn->error;
    $conn->close();
    exit;
}

// detailpenjualan: kodepj, kode, hjual, qty, subtotal
for ($i = 0; $i < count($datadetail); $i++) {
    $sql1 = "INSERT INTO detailpenjualan
        (kodepj, kode, hjual, qty, subtotal)
        VALUES (
        '$kodepj',
        '{$datadetail[$i]->kode}',
        {$datadetail[$i]->hjual},
        {$datadetail[$i]->qty},
        {$datadetail[$i]->subtotal})";

    if (!$conn->query($sql1)) {
        echo "Error detail: " . $conn->error;
    }
}

$conn->close();
?>