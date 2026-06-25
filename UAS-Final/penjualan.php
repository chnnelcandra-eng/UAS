<div class="container mt-4">
        <div class="card shadow p-4">
            <h5 class="mb-4">Penjualan Toko Candra</h5>
            <div class="row mb-3 mt-3">
                <div class="col-md-3">
                    <label>Tanggal</label>
                    <input type="date" id="tgl" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Nama Konsumen</label>
                    <input type="text" id="customerName" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>No. HP</label>
                    <input type="text" id="phoneNum" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Keterangan</label>
                    <input type="text" id="keterangan" class="form-control">
                </div>
            </div>
            <div class="row mb-3 align-items-end">
                <div class="col-md-1">
                    <label>Kode</label>
                    <input type="text" id="kode" readonly data-bs-toggle="modal" data-bs-target="#masteritem" class="form-control" placeholder="klik pilih">
                </div>
                <div class="col-md-2">
                    <label>Nama</label>
                    <input type="text" id="nama" readonly class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Satuan</label>
                    <input type="text" id="satuan" readonly class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Harga</label>
                    <input type="text" id="harga" readonly class="form-control text-end">
                </div>
                <div class="col-md-2">
                    <label>Qty</label>
                    <input type="number" id="qtyinput" value="1" min="1" class="form-control text-end">
                </div>
                <div class="col-md-2">
                    <label>Subtotal</label>
                    <input type="text" id="subtotalPreview" readonly class="form-control text-end">
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary w-100" id="tambah">+</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Action</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="tabledata"></tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4 ms-auto">
                    <div class="card border p-3">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td class="text-end" id="displayTotal">Rp 0</td>
                            </tr>
                            <tr>
                                <td><b>Diskon</b></td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" id="diskon" value="0" class="form-control text-end">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end text-muted small" id="detailDiskon"></td>
                            </tr>
                            <tr class="bg-warning">
                                <td><b>GRAND TOTAL</b></td>
                                <td class="text-end"><b id="grandtotal">Rp 0</b></td>
                            </tr>
                            <tr>
                                <td><b>Bayar</b></td>
                                <td><input type="number" id="bayar" class="form-control text-end"></td>
                            </tr>
                            <tr>
                                <td><b>Kembalian</b></td>
                                <td><input type="text" id="kembalian" class="form-control text-end" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end pt-2">
                                    <button class="btn btn-success" id="simpanTransaksi">Simpan</button>
                                    <!-- POSISI 3: Ganti onclick Close -->
                                    <a onclick="kembaliKeView()" class="btn btn-secondary ms-1" style="cursor:pointer">Close</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL MASTER ITEM -->
    <div class="modal" id="masteritem">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Master Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchItem" class="form-control mb-3" placeholder="Cari kode / nama barang...">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody id="modalItemBody">
                            <tr><td colspan="5" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
(function () {

    function parseRupiah(text) {
        return parseInt(String(text).replace(/\D/g, '')) || 0;
    }

    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka || 0).toLocaleString('id-ID');
    }

    function memilih(kode, nama, satuan, harga) {
        $('#kode').val(kode);
        $('#nama').val(nama);
        $('#satuan').val(satuan);
        $('#harga').val(formatRupiah(harga));
        $('#harga').data('raw', harga);
        hitungPreview();
    }

    window._memilih = memilih;

    function hitungPreview() {
        var harga = parseInt($('#harga').data('raw')) || 0;
        var q = parseFloat($('#qtyinput').val()) || 0;
        $('#subtotalPreview').val(formatRupiah(harga * q));
    }

    function hitungTotal() {
        var total = 0;
        $('#tabledata tr').each(function () {
            total += parseFloat($(this).find('.subtotal-raw').val()) || 0;
        });
        var diskonInput = parseFloat($('#diskon').val()) || 0;
        var nilaiDiskon = total * diskonInput / 100;
        var grand = Math.max(total - nilaiDiskon, 0);
        $('#displayTotal').text(formatRupiah(total));
        $('#grandtotal').text(formatRupiah(grand));
        $('#grandtotal').data('raw', grand);
        $('#detailDiskon').text(diskonInput > 0
            ? 'Diskon ' + diskonInput + '% = ' + formatRupiah(nilaiDiskon) : '');
        hitungKembalian();
    }

    function hitungKembalian() {
        var b = parseFloat($('#bayar').val()) || 0;
        var g = parseFloat($('#grandtotal').data('raw')) || 0;
        $('#kembalian').val(b - g < 0 ? 'Uang kurang' : formatRupiah(b - g));
    }

    function buatBaris(kode, nama, satuan, harga, qty, subtotal) {
        return '<tr>'
            + '<td><button class="btn btn-danger btn-sm rem">X</button></td>'
            + '<td>' + kode + '</td>'
            + '<td>' + nama + '</td>'
            + '<td>' + satuan + '</td>'
            + '<td class="text-end">' + formatRupiah(harga) + '<input type="hidden" class="harga-raw" value="' + harga + '"></td>'
            + '<td class="text-end">' + qty + '</td>'
            + '<td class="text-end">' + formatRupiah(subtotal) + '<input type="hidden" class="subtotal-raw" value="' + subtotal + '"></td>'
            + '</tr>';
    }

    // ===== MODAL ITEMS =====
    var allItems = [];

    function renderModalItems(data) {
        if (data.length === 0) {
            $('#modalItemBody').html('<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>');
            return;
        }
        var rows = '';
        data.forEach(function (item) {
            rows += '<tr>'
                + '<td><button class="btn btn-success btn-sm" data-bs-dismiss="modal"'
                + ' onclick="window._memilih(\'' + item.kode + '\',\'' + item.nama.replace(/'/g, "\\'") + '\',\'' + item.satuan + '\',\'' + item.hjual + '\')">pilih</button></td>'
                + '<td>' + item.kode + '</td>'
                + '<td>' + item.nama + '</td>'
                + '<td>' + item.satuan + '</td>'
                + '<td class="text-end">' + formatRupiah(item.hjual) + '</td>'
                + '</tr>';
        });
        $('#modalItemBody').html(rows);
    }

    $('#masteritem').off('show.bs.modal').on('show.bs.modal', function () {
        $('#searchItem').val('');
        if (allItems.length > 0) { renderModalItems(allItems); return; }
        $('#modalItemBody').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
        $.getJSON('get_items.php', function (data) {
            allItems = data;
            renderModalItems(allItems);
        }).fail(function () {
            $('#modalItemBody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>');
        });
    });

    $(document).off('input', '#searchItem').on('input', '#searchItem', function () {
        var keyword = $(this).val().toLowerCase();
        var filtered = allItems.filter(function (item) {
            return item.kode.toLowerCase().includes(keyword) || item.nama.toLowerCase().includes(keyword);
        });
        renderModalItems(filtered);
    });

    // ===== INIT =====
    $('#tgl').val(new Date().toISOString().split('T')[0]);
    $('#harga').data('raw', 0);

    $(document).off('input', '#qtyinput').on('input', '#qtyinput', hitungPreview);

    $(document).off('click', '#tambah').on('click', '#tambah', function (e) {
        e.preventDefault();
        var k   = $('#kode').val();
        var n   = $('#nama').val();
        var sat = $('#satuan').val();
        var h   = parseInt($('#harga').data('raw')) || 0;
        var q   = parseFloat($('#qtyinput').val());
        var s   = h * q;

        if (!k) return alert('Pilih barang dulu!');
        if (!q || q <= 0) return alert('Qty tidak boleh 0!');

        var isDuplicate = false;
        $('#tabledata tr').each(function () {
            if ($(this).find('td:eq(1)').text() === k) {
                isDuplicate = true;
                var oldQty = parseFloat($(this).find('td:eq(5)').text()) || 0;
                var newQty = oldQty + q;
                var newSub = h * newQty;
                $(this).find('td:eq(5)').text(newQty);
                $(this).find('td:eq(6)').html(formatRupiah(newSub) + '<input type="hidden" class="subtotal-raw" value="' + newSub + '">');
                hitungTotal();
                return false;
            }
        });

        if (!isDuplicate) {
            $('#tabledata').append(buatBaris(k, n, sat, h, q, s));
            hitungTotal();
        }

        $('#kode').val(''); $('#nama').val(''); $('#satuan').val('');
        $('#harga').val(''); $('#harga').data('raw', 0);
        $('#qtyinput').val(1); $('#subtotalPreview').val('');
    });

    $(document).off('click', '.rem').on('click', '.rem', function () {
        $(this).closest('tr').remove();
        hitungTotal();
    });

    $(document).off('input', '#diskon').on('input', '#diskon', hitungTotal);
    $(document).off('input', '#bayar').on('input', '#bayar', hitungKembalian);

    // ===== SIMPAN =====
    $(document).off('click', '#simpanTransaksi').on('click', '#simpanTransaksi', function () {
        if ($('#tabledata tr').length === 0) return alert('Tambahkan item terlebih dahulu!');
        if (!$('#customerName').val()) return alert('Nama konsumen harus diisi!');
        if (!$('#tgl').val()) return alert('Pilih tanggal dulu!');

        var now    = new Date();
        var kodepj = "pj" + now.getFullYear()
                   + String(now.getMonth()+1).padStart(2,'0')
                   + String(now.getDate()).padStart(2,'0')
                   + String(now.getHours()).padStart(2,'0')
                   + String(now.getMinutes()).padStart(2,'0')
                   + String(now.getSeconds()).padStart(2,'0');

        var total      = parseRupiah($("#displayTotal").text());
        var diskon     = parseFloat($("#diskon").val()) || 0;
        var grandtotal = parseRupiah($("#grandtotal").text());

        var detail = [];
        $("#tabledata tr").each(function () {
            detail.push({
                kode     : $(this).find("td:eq(1)").text(),
                hjual    : $(this).find(".harga-raw").val(),
                qty      : $(this).find("td:eq(5)").text(),
                subtotal : $(this).find(".subtotal-raw").val()
            });
        });

        var formData = new FormData();
        formData.append('kodepj',       kodepj);
        formData.append('tgl',          $("#tgl").val());
        formData.append('customerName', $("#customerName").val());
        formData.append('phoneNum',     $("#phoneNum").val());
        formData.append('ket',          $("#keterangan").val());
        formData.append('total',        total);
        formData.append('diskon',       diskon);
        formData.append('grandtotal',   grandtotal);
        formData.append('detail',       JSON.stringify(detail));

        $.ajax({
            url         : 'latihanphp10.php',
            type        : 'POST',
            data        : formData,
            processData : false,
            contentType : false,
            // POSISI 2: Ganti success handler
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Transaksi berhasil disimpan!");
                    kembaliKeView();
                } else {
                    alert("Gagal menyimpan!\n\n" + response);
                }
            },
            error: function (xhr, status, error) {
                alert("Gagal menyimpan!\n\nError: " + error);
            }
        });
    });

    // POSISI 1: Tambah fungsi kembaliKeView sebelum penutup })()
    window.kembaliKeView = function () {
        var now       = new Date();
        var today     = now.toISOString().split('T')[0];
        var awalBulan = now.getFullYear() + '-'
                      + String(now.getMonth()+1).padStart(2,'0') + '-01';
        $("#isi").load("view.php", function () {
            $("#filterDari").val(awalBulan);
            $("#filterSampai").val(today);
            $.post("filter_penjualan.php", { dari: awalBulan, sampai: today }, function (res) {
                $("#tbodyPenjualan").html(res);
                if (typeof hitungTotalKeseluruhan === "function") hitungTotalKeseluruhan();
            });
        });
    };

})();
</script>