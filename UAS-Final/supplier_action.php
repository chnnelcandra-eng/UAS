<?php
include 'koneksi.php';

$aksi = $_POST['aksi'] ?? '';

if ($aksi === 'insert') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $cp   = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $hp   = mysqli_real_escape_string($conn, $_POST['hp']);
    $almt = mysqli_real_escape_string($conn, $_POST['alamat']);
    $ket  = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "INSERT INTO supplier (nama_perusahaan, contact_person, hp, alamat, keterangan)
            VALUES ('$nama','$cp','$hp','$almt','$ket')";
    echo mysqli_query($conn, $sql) ? 'ok' : mysqli_error($conn);

} elseif ($aksi === 'update') {
    $id   = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $cp   = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $hp   = mysqli_real_escape_string($conn, $_POST['hp']);
    $almt = mysqli_real_escape_string($conn, $_POST['alamat']);
    $ket  = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "UPDATE supplier SET
                nama_perusahaan='$nama',
                contact_person='$cp',
                hp='$hp',
                alamat='$almt',
                keterangan='$ket'
            WHERE id=$id";
    echo mysqli_query($conn, $sql) ? 'ok' : mysqli_error($conn);

} elseif ($aksi === 'delete') {
    $id  = (int)$_POST['id'];
    $sql = "DELETE FROM supplier WHERE id=$id";
    echo mysqli_query($conn, $sql) ? 'ok' : mysqli_error($conn);

} else {
    echo 'aksi tidak dikenal';
}
?>