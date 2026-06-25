<?php include "koneksi.php"; ?>

<div class="container mt-3">
    <button type="button" class="btn btn-success mb-2"
        onclick='$("#isi").load("penjualan.php")'>
        Tambah
    </button>
</div>

<div class="row mb-3 mt-2">
    <div class="col-auto">
        <label>Dari</label>
        <input type="date" class="form-control" id="filterDari">
    </div>
    <div class="col-auto">
        <label>Sampai</label>
        <input type="date" class="form-control" id="filterSampai">
    </div>
    <div class="col-auto d-flex align-items-end">
        <button class="btn btn-primary me-1" id="btnFilter">Filter</button>
        <button class="btn btn-secondary" id="btnReset">Reset</button>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Action</th>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>HP</th>
            <th style="text-align:right">Grandtotal</th>
        </tr>
    </thead>
    <tbody id="tbodyPenjualan">
        <tr><td colspan="6" class="text-center">Loading...</td></tr>
    </tbody>
</table>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Detail Penjualan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Kode PJ :</b> <span id="dkodepj"></span></p>
                        <p><b>Tanggal :</b> <span id="dtgl"></span></p>
                        <p><b>Customer :</b> <span id="dcustomer"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><b>No HP :</b> <span id="dhp"></span></p>
                        <p><b>Keterangan :</b> <span id="dket"></span></p>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th style="text-align:right">Qty</th>
                            <th style="text-align:right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detailTable"></tbody>
                    <tfoot>
                        <tr><td colspan="4" align="right"><b>Total</b></td><td id="dtotal" style="text-align:right"></td></tr>
                        <tr><td colspan="4" align="right"><b>Diskon</b></td><td id="ddiskon" style="text-align:right"></td></tr>
                        <tr><td colspan="4" align="right"><b>Grand Total</b></td><td id="dgrandtotal" style="text-align:right"></td></tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" id="btnCetakStruk" disabled>Struk</button>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-2 me-2">
    <h5><b>Total Keseluruhan : Rp <span id="totalKeseluruhan">0</span></b></h5>
</div>

<script>
// Dibungkus IIFE supaya const/let tidak bentrok waktu $.load() dipanggil berkali-kali
(function() {

    function formatTanggal(str) {
        if (!str) return '';
        var parts = str.split(/[- ]/);
        if (parts.length >= 3) return parts[2].substring(0,2) + '/' + parts[1] + '/' + parts[0];
        return str;
    }

    function hitungTotalKeseluruhan() {
        var total = 0;
        $("#tbodyPenjualan tr").each(function () {
            var val = $(this).find("td:last").text().replace(/\./g, '').replace(',', '.');
            total += parseFloat(val) || 0;
        });
        $("#totalKeseluruhan").text(total.toLocaleString('id-ID'));
        localStorage.setItem("totalPenjualan", total);
        return total;
    }

    // Expose supaya bisa dipanggil dari luar (index.php dll)
    window.hitungTotalKeseluruhan = hitungTotalKeseluruhan;

    function loadData(dari, sampai) {
        $.ajax({
            url: "filter.php",
            type: "POST",
            data: { dari: dari, sampai: sampai },
            success: function (res) {
                $("#tbodyPenjualan").html(res);
                hitungTotalKeseluruhan();
            }
        });
    }

    var today = new Date().toISOString().split('T')[0];
    var dari   = localStorage.getItem("filterDari")   || today;
    var sampai = localStorage.getItem("filterSampai") || today;

    localStorage.setItem("filterDari",   dari);
    localStorage.setItem("filterSampai", sampai);

    $("#filterDari").val(dari);
    $("#filterSampai").val(sampai);

    loadData(dari, sampai);

    $(document).off("click", "#btnFilter").on("click", "#btnFilter", function () {
        var dari   = $("#filterDari").val();
        var sampai = $("#filterSampai").val();
        if (!dari || !sampai) { alert("Pilih tanggal dari dan sampai dulu!"); return; }
        localStorage.setItem("filterDari",   dari);
        localStorage.setItem("filterSampai", sampai);
        loadData(dari, sampai);
    });

    $(document).off("click", "#btnReset").on("click", "#btnReset", function () {
        var today = new Date().toISOString().split('T')[0];
        $("#filterDari").val(today);
        $("#filterSampai").val(today);
        localStorage.setItem("filterDari",   today);
        localStorage.setItem("filterSampai", today);
        loadData(today, today);
    });

    $(document).off("click", ".pilih-baris").on("click", ".pilih-baris", function (e) {
        if ($(e.target).closest(".btn-detail").length) return;
        $(".pilih-baris").removeClass("table-warning");
        $(this).addClass("table-warning");
    });

    $(document).off("click", ".btn-detail").on("click", ".btn-detail", function () {
        var kodepj = $(this).data("kodepj");
        $.ajax({
            url: "detail_transaksi.php",
            type: "POST",
            data: { kodepj: kodepj },
            dataType: "json",
            success: function (res) {
                $("#dkodepj").text(res.header.kodepj);
                $("#dtgl").text(formatTanggal(res.header.tgl));
                $("#dcustomer").text(res.header.customerName);
                $("#dhp").text(res.header.phoneNum);
                $("#dket").text(res.header.keterangan);
                var rows = "";
                res.detail.forEach(function (item) {
                    rows += '<tr>'
                        + '<td>' + item.kode + '</td>'
                        + '<td>' + item.nama + '</td>'
                        + '<td>' + item.satuan + '</td>'
                        + '<td style="text-align:right">' + item.qty + '</td>'
                        + '<td style="text-align:right">' + Number(item.subtotal).toLocaleString('id-ID') + '</td>'
                        + '</tr>';
                });
                $("#detailTable").html(rows);
                $("#dtotal").text(Number(res.header.total).toLocaleString('id-ID'));
                $("#ddiskon").text(Number(res.header.diskon).toLocaleString('id-ID'));
                $("#dgrandtotal").text(Number(res.header.subtotal).toLocaleString('id-ID'));
                $("#btnCetakStruk").prop("disabled", false);
            },
            error: function (xhr) { alert("Error: " + xhr.responseText); }
        });
    });

    $(document).off("click", "#btnCetakStruk").on("click", "#btnCetakStruk", function () {
        var kodepj = $("#dkodepj").text();
        window.open('struk.php?kodepj=' + kodepj, '_blank');
    });

    $(document).off("hidden.bs.modal", "#modalDetail").on("hidden.bs.modal", "#modalDetail", function () {
        hitungTotalKeseluruhan();
    });

})();
</script>