<?php
include "koneksi.php"; 
?>

<div class="container mt-3">
    <div class="card bg-success text-white mb-3">
        <div class="card-body">Product</div>
    </div>

    <button class="btn btn-success mb-3" id="btnTambahProduct">+ Tambah Product</button>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Action</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th class="text-end">Harga Beli</th>
                <th class="text-end">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM items ORDER BY kode ASC");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <button class="btn btn-warning btn-sm btn-edit"
                        data-kode="<?= htmlspecialchars($row['kode'], ENT_QUOTES) ?>"
                        data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>"
                        data-satuan="<?= htmlspecialchars($row['satuan'], ENT_QUOTES) ?>"
                        data-hbeli="<?= htmlspecialchars($row['hbeli'], ENT_QUOTES) ?>"
                        data-hjual="<?= htmlspecialchars($row['hjual'], ENT_QUOTES) ?>">Edit</button>
                    <button class="btn btn-danger btn-sm btn-delete"
                        data-kode="<?= htmlspecialchars($row['kode'], ENT_QUOTES) ?>">Hapus</button>
                </td>
                <td><?= htmlspecialchars($row['kode']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['satuan']) ?></td>
                <td class="text-end"><?= number_format($row['hbeli'], 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($row['hjual'], 0, ',', '.') ?></td>
            </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">Belum ada data product</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Form Product -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalTitle">Tambah Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="p-mode">
                <div class="mb-2">
                    <label class="form-label">Kode</label>
                    <input type="text" class="form-control" id="p-kode">
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="p-nama">
                </div>
                <div class="mb-2">
                    <label class="form-label">Satuan</label>
                    <input type="text" class="form-control" id="p-satuan">
                </div>
                <div class="mb-2">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="p-hbeli">
                </div>
                <div class="mb-2">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="p-hjual">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btnSimpanProduct">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    // Pakai bootstrap.Modal.getOrCreateInstance supaya tidak bentrok kalau load ulang
    function getModal() {
        return bootstrap.Modal.getOrCreateInstance(document.getElementById("productModal"));
    }

    function reloadProduct() {
        $("#isi").load("product.php", function () {
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open").css({ overflow: "", paddingRight: "" });
        });
    }

    $("#btnTambahProduct").off("click").on("click", function () {
        $("#p-mode").val("insert");
        $("#productModalTitle").text("Tambah Product");
        $("#p-kode").val("").prop("readonly", false);
        $("#p-nama").val("");
        $("#p-satuan").val("");
        $("#p-hbeli").val("");
        $("#p-hjual").val("");
        getModal().show();
    });

    $(".btn-edit").off("click").on("click", function () {
        $("#p-mode").val("update");
        $("#productModalTitle").text("Edit Product");
        $("#p-kode").val($(this).data("kode")).prop("readonly", true);
        $("#p-nama").val($(this).data("nama"));
        $("#p-satuan").val($(this).data("satuan"));
        $("#p-hbeli").val($(this).data("hbeli"));
        $("#p-hjual").val($(this).data("hjual"));
        getModal().show();
    });

    $(".btn-delete").off("click").on("click", function () {
        var kode = $(this).data("kode");
        if (!confirm("Yakin hapus product '" + kode + "' ?")) return;
        $.post("product_crud.php", { action: "delete", kode: kode }, function (res) {
            if (res.trim() !== "OK") { alert(res); return; }
            reloadProduct();
        });
    });

    $("#btnSimpanProduct").off("click").on("click", function () {
        var data = {
            action: $("#p-mode").val(),
            kode:   $("#p-kode").val().trim(),
            nama:   $("#p-nama").val().trim(),
            satuan: $("#p-satuan").val().trim(),
            hbeli:  $("#p-hbeli").val() || 0,
            hjual:  $("#p-hjual").val() || 0
        };
        if (!data.kode || !data.nama) {
            alert("Kode dan Nama Barang wajib diisi!");
            return;
        }
        $.post("product_crud.php", data, function (res) {
            if (res.trim() !== "OK") { alert(res); return; }
            getModal().hide();
            reloadProduct();
        });
    });
})();
</script>