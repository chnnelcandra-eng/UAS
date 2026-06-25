<?php include 'koneksi.php'; ?>

<div class="container mt-3">
    <button type="button" class="btn btn-success mb-2"
        onclick='$("#isi").load("pembelian.php")'>
        Tambah
    </button>
</div>

<div class="row mb-3 mt-2">
    <div class="col-auto">
        <label>Dari</label>
        <input type="date" class="form-control" id="filterDariPB">
    </div>
    <div class="col-auto">
        <label>Sampai</label>
        <input type="date" class="form-control" id="filterSampaiPB">
    </div>
    <div class="col-auto d-flex align-items-end">
        <button class="btn btn-primary me-1" id="btnFilterPB">Filter</button>
        <button class="btn btn-secondary" id="btnResetPB">Reset</button>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Action</th>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Nama Perusahaan</th>
            <th>HP</th>
            <th class="text-end">Grand Total</th>
        </tr>
    </thead>
    <tbody id="tbodyPembelian">
        <tr><td colspan="6" class="text-center">Loading...</td></tr>
    </tbody>
</table>

<!-- PAGINATION -->
<div class="d-flex justify-content-center mt-3">
    <div id="pagination"></div>
</div>

<!-- TOTAL -->
<div class="d-flex justify-content-end mt-2 me-2">
    <h5><b>Total Keseluruhan : Rp <span id="totalKeseluruhanPB">0</span></b></h5>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetailPB">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Detail Pembelian</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Kode PB :</b> <span id="pb_kode"></span></p>
                        <p><b>Tanggal :</b> <span id="pb_tgl"></span></p>
                        <p><b>Nama Perusahaan :</b> <span id="pb_nama"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Contact Person :</b> <span id="pb_cp"></span></p>
                        <p><b>HP :</b> <span id="pb_hp"></span></p>
                        <p><b>Keterangan :</b> <span id="pb_ket"></span></p>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="pb_detailTable"></tbody>
                    <tfoot>
                        <tr><td colspan="5" class="text-end"><b>Total</b></td><td class="text-end" id="pb_total"></td></tr>
                        <tr><td colspan="5" class="text-end"><b>Diskon</b></td><td class="text-end" id="pb_diskon"></td></tr>
                        <tr><td colspan="5" class="text-end"><b>Grand Total</b></td><td class="text-end" id="pb_grandtotal"></td></tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {

    var semuaData  = [];
    var currentPage = 1;
    var perPage     = 10;

    function hitungTotal() {
        var total = 0;
        semuaData.forEach(function (row) {
            total += parseFloat(row.grandtotal) || 0;
        });
        $("#totalKeseluruhanPB").text(total.toLocaleString('id-ID'));
    }

    function renderTable() {
        var start    = (currentPage - 1) * perPage;
        var end      = start + perPage;
        var pageData = semuaData.slice(start, end);

        if (pageData.length === 0) {
            $("#tbodyPembelian").html('<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>');
            $("#pagination").html('');
            return;
        }

        var rows = '';
        pageData.forEach(function (row) {
            var tgl = row.tgl ? row.tgl.split('-').reverse().join('/') : '';
            rows += '<tr>'
                + '<td><button class="btn btn-info btn-sm btn-detail-pb" data-kodepb="' + row.kodepb + '">Detail</button></td>'
                + '<td>' + row.kodepb + '</td>'
                + '<td>' + tgl + '</td>'
                + '<td>' + row.nama_perusahaan + '</td>'
                + '<td>' + row.hp + '</td>'
                + '<td class="text-end">' + Number(row.grandtotal).toLocaleString('id-ID') + '</td>'
                + '</tr>';
        });
        $("#tbodyPembelian").html(rows);
        renderPagination();
    }

    function renderPagination() {
        var totalPages = Math.ceil(semuaData.length / perPage);
        if (totalPages <= 1) { $("#pagination").html(''); return; }

        var html = '<ul class="pagination pagination-sm mb-0">';

        html += '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '">'
            + '<a class="page-link" href="#" data-page="' + (currentPage - 1) + '">&laquo;</a></li>';

        for (var i = 1; i <= totalPages; i++) {
            html += '<li class="page-item ' + (i === currentPage ? 'active' : '') + '">'
                + '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
        }

        html += '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '">'
            + '<a class="page-link" href="#" data-page="' + (currentPage + 1) + '">&raquo;</a></li>';

        html += '</ul>';
        $("#pagination").html(html);
    }

    function loadData(dari, sampai) {
        $("#tbodyPembelian").html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: "filter_pembelian.php",
            type: "POST",
            data: { dari: dari, sampai: sampai, format: 'json' },
            dataType: "json",
            success: function (res) {
                semuaData   = res;
                currentPage = 1;
                hitungTotal();
                renderTable();
            }
        });
    }

    var today  = new Date().toISOString().split('T')[0];
    var dari   = localStorage.getItem("filterDariPB")   || today;
    var sampai = localStorage.getItem("filterSampaiPB") || today;

    $("#filterDariPB").val(dari);
    $("#filterSampaiPB").val(sampai);
    loadData(dari, sampai);

    $(document).off("click", "#btnFilterPB").on("click", "#btnFilterPB", function () {
        var dari   = $("#filterDariPB").val();
        var sampai = $("#filterSampaiPB").val();
        if (!dari || !sampai) { alert("Pilih tanggal dulu!"); return; }
        localStorage.setItem("filterDariPB",   dari);
        localStorage.setItem("filterSampaiPB", sampai);
        loadData(dari, sampai);
    });

    $(document).off("click", "#btnResetPB").on("click", "#btnResetPB", function () {
        var today = new Date().toISOString().split('T')[0];
        $("#filterDariPB").val(today);
        $("#filterSampaiPB").val(today);
        localStorage.setItem("filterDariPB",   today);
        localStorage.setItem("filterSampaiPB", today);
        loadData(today, today);
    });

    $(document).off("click", ".page-link").on("click", ".page-link", function (e) {
    e.preventDefault();
    var page       = 2;
    var totalPages = Math.ceil(semuaData.length / perPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderTable();
    });

    $(document).off("click", ".btn-detail-pb").on("click", ".btn-detail-pb", function () {
        var kodepb = $(this).data("kodepb");
        $.ajax({
            url: "detail_pembelian.php",
            type: "POST",
            data: { kodepb: kodepb },
            dataType: "json",
            success: function (res) {
                $("#pb_kode").text(res.header.kodepb);
                $("#pb_tgl").text(res.header.tgl ? res.header.tgl.split('-').reverse().join('/') : '');
                $("#pb_nama").text(res.header.nama_perusahaan);
                $("#pb_cp").text(res.header.contact_person);
                $("#pb_hp").text(res.header.hp);
                $("#pb_ket").text(res.header.keterangan);
                var rows = "";
                res.detail.forEach(function (item) {
                    rows += '<tr>'
                        + '<td>' + item.kode_item + '</td>'
                        + '<td>' + item.nama + '</td>'
                        + '<td>' + item.satuan + '</td>'
                        + '<td class="text-end">' + Number(item.harga).toLocaleString('id-ID') + '</td>'
                        + '<td class="text-end">' + item.qty + '</td>'
                        + '<td class="text-end">' + Number(item.subtotal).toLocaleString('id-ID') + '</td>'
                        + '</tr>';
                });
                $("#pb_detailTable").html(rows);
                $("#pb_total").text(Number(res.header.total).toLocaleString('id-ID'));
                $("#pb_diskon").text(Number(res.header.diskon).toLocaleString('id-ID'));
                $("#pb_grandtotal").text(Number(res.header.grandtotal).toLocaleString('id-ID'));
                var modal = new bootstrap.Modal(document.getElementById('modalDetailPB'));
                modal.show();
            }
        });
    });

})();
</script>