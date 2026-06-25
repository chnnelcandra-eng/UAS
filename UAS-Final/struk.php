<?php
include "koneksi.php";
$kodepj = $_GET['kodepj'];

$q1 = mysqli_query($conn, "SELECT * FROM masterpenjualan WHERE kodepj='$kodepj'");
$header = mysqli_fetch_assoc($q1);

$q2 = mysqli_query($conn, "
    SELECT d.*, i.nama, i.satuan
    FROM detailpenjualan d
    JOIN items i ON d.kode = i.kode
    WHERE d.kodepj='$kodepj'
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Struk</title>
  <style>
    body { font-family: monospace; font-size: 13px; width: 400px; margin: auto; padding: 20px; }
    .divider { border-top: 1px dashed #000; margin: 8px 0; }
    table { width: 100%; }
    .text-right { text-align: right; }
    @media print { .no-print { display: none; } }
  </style>
</head>
<body>

  <div style="text-align:center;">
    <h3>AKU BAKUL SEMBAKO</h3>
    <p>Jl. Wanara, Rt 01, Rw 07, Dusun Kedungbader, Kota jombang <br>Telp: 085776794303</p>
  </div>

  <div class="divider"></div>

  <p>No &nbsp;&nbsp;&nbsp;: <?= $header['kodepj'] ?></p>
  <p>Tgl &nbsp;&nbsp;: <?= $header['tgl'] ?></p>
  <p>Nama &nbsp;: <?= $header['customerName'] ?></p>
  <p>No HP : <?= $header['phoneNum'] ?></p>
  <p>Ket &nbsp;&nbsp;: <?= $header['keterangan'] ?></p>

  <div class="divider"></div>

  <table>
    <thead>
      <tr>
        <th>Nama</th>
        <th class="text-right">Qty</th>
        <th class="text-right">Harga</th>
        <th class="text-right">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($d = mysqli_fetch_assoc($q2)): ?>
      <tr>
        <td><?= $d['nama'] ?></td>
        <td class="text-right"><?= $d['qty'] ?></td>
        <td class="text-right"><?= $d['hjual'] ?></td>
        <td class="text-right"><?= $d['subtotal'] ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="divider"></div>

  <table>
    <tr><td>Total</td><td class="text-right">Rp <?= $header['total'] ?></td></tr>
    <tr><td>Diskon</td><td class="text-right">Rp <?= $header['diskon'] ?></td></tr>
    <tr><td><b>Grand Total</b></td><td class="text-right"><b>Rp <?= $header['subtotal'] ?></b></td></tr>
  </table>

  <div class="divider"></div>

  <p style="text-align:center;">Terima kasih sudah berbelanja!</p>

  <div class="no-print" style="text-align:center; margin-top:20px;">
    <button onclick="window.print()">Print</button>
    <button onclick="window.close()">Close</button>
  </div>

</body>
</html>