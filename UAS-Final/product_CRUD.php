<?php
// ============================================================
// product_crud.php
// Fungsi: BACKEND CRUD PRODUCT (tabel items).
// Menerima POST 'action' = insert | update | delete, lalu menjalankan
// query yang sesuai. Dipanggil via AJAX dari product.php.
// Balasan: "OK" kalau sukses, "ERR: ..." kalau gagal.
// ============================================================
include "koneksi.php"; // koneksi ke database ($conn)

// Ambil aksi yang diminta
$action = $_POST['action'] ?? '';

// Ambil & amankan input (escape untuk teks, cast ke angka untuk harga)
$kode   = $conn->real_escape_string($_POST['kode']   ?? '');
$nama   = $conn->real_escape_string($_POST['nama']   ?? '');
$satuan = $conn->real_escape_string($_POST['satuan'] ?? '');
$hbeli  = (float)($_POST['hbeli'] ?? 0);
$hjual  = (float)($_POST['hjual'] ?? 0);

if ($action === 'insert') {
    // Cegah kode dobel (kode = primary key)
    $cek = $conn->query("SELECT kode FROM items WHERE kode = '$kode'");
    if ($cek && $cek->num_rows > 0) {
        echo "ERR: Kode '$kode' sudah ada, gunakan kode lain.";
        exit;
    }
    $sql = "INSERT INTO items (kode, nama, satuan, hbeli, hjual)
            VALUES ('$kode', '$nama', '$satuan', $hbeli, $hjual)";
} elseif ($action === 'update') {
    // Kode tidak diubah (dipakai sebagai kunci pencarian)
    $sql = "UPDATE items
            SET nama = '$nama', satuan = '$satuan', hbeli = $hbeli, hjual = $hjual
            WHERE kode = '$kode'";
} elseif ($action === 'delete') {
    $sql = "DELETE FROM items WHERE kode = '$kode'";
} else {
    echo "ERR: Aksi tidak dikenal.";
    exit;
}

// Jalankan query lalu kirim status balik ke AJAX
if ($conn->query($sql) === TRUE) {
    echo "OK";
} else {
    echo "ERR: " . $conn->error;
}

$conn->close();
?>