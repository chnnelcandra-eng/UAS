<?php
include 'koneksi.php';

$tgl    = $_POST['tgl'];
$nama   = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
$cp     = mysqli_real_escape_string($conn, $_POST['contact_person']);
$hp     = mysqli_real_escape_string($conn, $_POST['hp']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$ket    = mysqli_real_escape_string($conn, $_POST['keterangan']);
$total  = floatval($_POST['total']);
$diskon = floatval($_POST['diskon']);
$grand  = floatval($_POST['grandtotal']);
$items  = json_decode($_POST['items'], true);

if (empty($items)) { echo 'Belum ada barang!'; exit; }

// Generate kode: pb + YmdHis
$kodepb = 'pb' . date('YmdHis');

$sql = "INSERT INTO masterpembelian (kodepb, tgl, nama_perusahaan, contact_person, hp, alamat, keterangan, total, diskon, grandtotal)
        VALUES ('$kodepb','$tgl','$nama','$cp','$hp','$alamat','$ket',$total,$diskon,$grand)";

if (!mysqli_query($conn, $sql)) { echo 'Gagal: ' . mysqli_error($conn); exit; }

foreach ($items as $item) {
    $ki  = mysqli_real_escape_string($conn, $item['kode']);
    $nm  = mysqli_real_escape_string($conn, $item['nama']);
    $sat = mysqli_real_escape_string($conn, $item['satuan']);
    $hg  = floatval($item['harga']);
    $qty = floatval($item['qty']);
    $sub = floatval($item['subtotal']);
    $sql2 = "INSERT INTO detailpembelian (kodepb, kode_item, nama, satuan, harga, qty, subtotal)
             VALUES ('$kodepb','$ki','$nm','$sat',$hg,$qty,$sub)";
    mysqli_query($conn, $sql2);
}

echo 'ok';
?>