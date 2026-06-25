<?php
include "koneksi.php";
$dari   = $_POST['dari']   ?? '';
$sampai = $_POST['sampai'] ?? '';

if ($dari && $sampai) {
    $dari_full   = $dari   . " 00:00:00";
    $sampai_full = $sampai . " 23:59:59";
    $sql = $conn->prepare("SELECT * FROM masterpenjualan WHERE tgl BETWEEN ? AND ? ORDER BY tgl ASC");
    $sql->bind_param("ss", $dari_full, $sampai_full);
} else {
    $sql = $conn->prepare("SELECT * FROM masterpenjualan ORDER BY tgl ASC");
}

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format tanggal dd/mm/yyyy
        $tgl = date('d/m/Y', strtotime($row["tgl"]));

        echo "<tr class='pilih-baris' data-kodepj='".$row["kodepj"]."' style='cursor:pointer;'>";
        echo "<td><button type='button' class='btn btn-info btn-sm btn-detail'
                data-bs-toggle='modal'
                data-bs-target='#modalDetail'
                data-kodepj='".$row["kodepj"]."'>Detail</button></td>";
        echo "<td>".$row["kodepj"]."</td>";
        echo "<td>".$tgl."</td>";
        echo "<td>".$row["customerName"]."</td>";
        echo "<td>".$row["phoneNum"]."</td>";
        echo "<td style='text-align:right'>".number_format($row["subtotal"], 0, ',', '.')."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
}
$conn->close();
?>