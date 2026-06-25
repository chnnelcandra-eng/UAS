<!DOCTYPE html>
<html lang="en">
<head>
  <title>Toko Candra</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-success navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="nav-link btn" id="dashboard">Dashboard</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="product">Product</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="penjualan">Penjualan</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="supplier">Supplier</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="viewpembelian">List Pembelian</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="pembelian">Pembelian</button>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div id="isi"></div>
    </div>

    <!-- Urutan benar: jQuery dulu, baru Bootstrap, baru script sendiri -->
    <script src="jquery-4.0.0.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <script src="chart.js"></script>
    <script>
        $("#isi").load('dashboard.php');
        $("#dashboard").on("click", function(){
            $("#isi").load('dashboard.php');
        });
        $("#product").on("click", function(){
            $("#isi").load('product.php');
        });
        $("#supplier").on("click", function(){
            $("#isi").load('supplier.php');
        });
        $("#viewpembelian").on("click", function(){
            $("#isi").load('view_pembelian.php');
        });
        $("#pembelian").on("click", function(){
            $("#isi").load('pembelian.php');
        });
        $("#penjualan").on("click", function(){
            $("#isi").load('view.php');
  });  
    </script>
</body>
</html>