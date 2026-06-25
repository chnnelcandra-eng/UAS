<?php
include 'koneksi.php';
$dari   = $_POST['dari'];
$sampai = $_POST['sampai'];
$format = $_POST['format'] ?? 'html';

$sql = "SELECT * FROM masterpembelian WHERE tgl BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($format === 'json') {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
    echo json_encode($data);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $tgl = date('d/m/Y', strtotime($row['tgl']));
        echo '<tr>
            <td><button class="btn btn-info btn-sm btn-detail-pb" data-kodepb="'.$row['kodepb'].'">Detail</button></td>
            <td>'.$row['kodepb'].'</td>
            <td>'.$tgl.'</td>
            <td>'.$row['nama_perusahaan'].'</td>
            <td>'.$row['hp'].'</td>
            <td class="text-end">'.number_format($row['grandtotal'],0,',','.').'</td>
        </tr>';
    }
}
?>