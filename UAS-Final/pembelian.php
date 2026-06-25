<div class="container mt-4">
    <div class="card shadow p-4">
        <h5 class="mb-4">Pembelian</h5>

        <!-- FORM ATAS -->
        <table class="table table-bordered" style="width: auto;">
            <tr>
                <th>Tgl Datang</th>
                <th>Nama Perusahaan</th>
                <th>Contact Person</th>
                <th>HP</th>
                <th>Alamat</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td><input type="date" class="form-control" id="tgl"></td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" id="namaPerusahaan" readonly placeholder="klik pilih">
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalPilihSupplier">pilih</button>
                    </div>
                </td>
                <td><input type="text" class="form-control" id="contactPerson"></td>
                <td><input type="text" class="form-control" id="phoneNum"></td>
                <td><input type="text" class="form-control" id="alamat"></td>
                <td><input type="text" class="form-control" id="keterangan"></td>
            </tr>
        </table>

        <!-- INPUT BARANG -->
        <div class="row mb-3 align-items-end">
            <div class="col-md-2">
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
            <div class="col-md-1">
                <label>Qty</label>
                <input type="number" id="qtyinput" value="1" class="form-control text-end">
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

        <!-- TABEL -->
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

            <!-- TOTAL -->
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
                                <td colspan="2" class="text-end pt-2">
                                    <button class="btn btn-success" id="simpanPembelian">Simpan</button>
                                    <a onclick='$("#isi").load("view_pembelian.php")' class="btn btn-secondary ms-1" style="cursor:pointer">Close</a>
                                </td>
                            </tr>
                        </table>
                    </div>
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
                <input type="text" id="searchItemBeli" class="form-control mb-3" placeholder="Cari kode / nama barang...">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th class="text-end">Harga Beli</th>
                        </tr>
                    </thead>
                    <tbody id="modalItemBodyBeli">
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

<!-- MODAL PILIH SUPPLIER -->
<div class="modal fade" id="modalPilihSupplier" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchSupplier" class="form-control mb-3" placeholder="Cari nama perusahaan...">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Nama Perusahaan</th>
                            <th>Contact Person</th>
                            <th>HP</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="modalSupplierBody">
                        <tr><td colspan="6" class="text-center">Loading...</td></tr>
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

    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka || 0).toLocaleString('id-ID');
    }

    var hargaMentah = 0;

    function memilih(kode, nama, satuan, harga) {
        hargaMentah = harga;
        $('#kode').val(kode);
        $('#nama').val(nama);
        $('#satuan').val(satuan);
        $('#harga').val(formatRupiah(harga));
        hitungPreview();
    }

    window._memilihBeli = memilih;

    function hitungPreview() {
        var q = parseFloat($('#qtyinput').val()) || 0;
        $('#subtotalPreview').val(formatRupiah(hargaMentah * q));
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

    // ===== MODAL: load items dari DB =====
    var allItemsBeli = [];

    function renderModalItemsBeli(data) {
        if (data.length === 0) {
            $('#modalItemBodyBeli').html('<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>');
            return;
        }
        var rows = '';
        data.forEach(function (item) {
            rows += '<tr>'
                + '<td><button class="btn btn-success btn-sm" data-bs-dismiss="modal"'
                + ' onclick="window._memilihBeli(\'' + item.kode + '\',\'' + item.nama.replace(/'/g, "\\'") + '\',\'' + item.satuan + '\',' + item.hbeli + ')">pilih</button></td>'
                + '<td>' + item.kode + '</td>'
                + '<td>' + item.nama + '</td>'
                + '<td>' + item.satuan + '</td>'
                + '<td class="text-end">' + formatRupiah(item.hbeli) + '</td>'
                + '</tr>';
        });
        $('#modalItemBodyBeli').html(rows);
    }

    $('#masteritem').off('show.bs.modal').on('show.bs.modal', function () {
        $('#searchItemBeli').val('');
        if (allItemsBeli.length > 0) { renderModalItemsBeli(allItemsBeli); return; }
        $('#modalItemBodyBeli').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
        $.getJSON('get_items.php', function (data) {
            allItemsBeli = data;
            renderModalItemsBeli(allItemsBeli);
        }).fail(function () {
            $('#modalItemBodyBeli').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>');
        });
    });

    $(document).off('input', '#searchItemBeli').on('input', '#searchItemBeli', function () {
        var keyword = $(this).val().toLowerCase();
        var filtered = allItemsBeli.filter(function (item) {
            return item.kode.toLowerCase().includes(keyword) || item.nama.toLowerCase().includes(keyword);
        });
        renderModalItemsBeli(filtered);
    });

    // ===== MODAL SUPPLIER =====
    var allSupplier = [];

    function renderSupplier(data) {
        if (data.length === 0) {
            $('#modalSupplierBody').html('<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>');
            return;
        }
        var rows = '';
        data.forEach(function (s) {
            rows += '<tr>'
                + '<td><button class="btn btn-success btn-sm" data-bs-dismiss="modal"'
                + ' onclick="window._pilihSupplier(\''
                + s.nama_perusahaan.replace(/'/g, "\\'") + '\',\''
                + s.contact_person.replace(/'/g, "\\'") + '\',\''
                + s.hp.replace(/'/g, "\\'") + '\',\''
                + s.alamat.replace(/'/g, "\\'") + '\',\''
                + s.keterangan.replace(/'/g, "\\'") + '\')">pilih</button></td>'
                + '<td>' + s.nama_perusahaan + '</td>'
                + '<td>' + s.contact_person + '</td>'
                + '<td>' + s.hp + '</td>'
                + '<td>' + s.alamat + '</td>'
                + '<td>' + s.keterangan + '</td>'
                + '</tr>';
        });
        $('#modalSupplierBody').html(rows);
    }

    window._pilihSupplier = function(nama, cp, hp, alamat, ket) {
        $('#namaPerusahaan').val(nama);
        $('#contactPerson').val(cp);
        $('#phoneNum').val(hp);
        $('#alamat').val(alamat);
        $('#keterangan').val(ket);
    };

    $('#modalPilihSupplier').off('show.bs.modal').on('show.bs.modal', function () {
        $('#searchSupplier').val('');
        if (allSupplier.length > 0) { renderSupplier(allSupplier); return; }
        $('#modalSupplierBody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.getJSON('get_supplier.php', function (data) {
            allSupplier = data;
            renderSupplier(allSupplier);
        }).fail(function () {
            $('#modalSupplierBody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data.</td></tr>');
        });
    });

    $(document).off('input', '#searchSupplier').on('input', '#searchSupplier', function () {
        var keyword = $(this).val().toLowerCase();
        var filtered = allSupplier.filter(function (s) {
            return s.nama_perusahaan.toLowerCase().includes(keyword);
        });
        renderSupplier(filtered);
    });

    // ===== INIT =====
    $('#tgl').val(new Date().toISOString().split('T')[0]);

    $(document).off('input', '#qtyinput').on('input', '#qtyinput', hitungPreview);

    $(document).off('click', '#tambah').on('click', '#tambah', function (e) {
        e.preventDefault();
        var k   = $('#kode').val();
        var n   = $('#nama').val();
        var sat = $('#satuan').val();
        var q   = parseFloat($('#qtyinput').val());
        var s   = hargaMentah * q;

        if (!k) return alert('Pilih barang dulu!');
        if (!q || q <= 0) return alert('Qty tidak boleh 0!');

        var isDuplicate = false;
        $('#tabledata tr').each(function () {
            if ($(this).find('td:eq(1)').text() === k) {
                isDuplicate = true;
                var oldQty = parseFloat($(this).find('td:eq(5)').text()) || 0;
                var newQty = oldQty + q;
                var newSub = hargaMentah * newQty;
                $(this).find('td:eq(5)').text(newQty);
                $(this).find('td:eq(6)').html(formatRupiah(newSub) + '<input type="hidden" class="subtotal-raw" value="' + newSub + '">');
                hitungTotal();
                return false;
            }
        });

        if (!isDuplicate) {
            $('#tabledata').append(buatBaris(k, n, sat, hargaMentah, q, s));
            hitungTotal();
        }

        $('#kode').val(''); $('#nama').val(''); $('#satuan').val('');
        $('#harga').val(''); hargaMentah = 0;
        $('#qtyinput').val(1); $('#subtotalPreview').val('');
    });

    $(document).off('click', '.rem').on('click', '.rem', function () {
        $(this).closest('tr').remove();
        hitungTotal();
    });

    $(document).off('input', '#diskon').on('input', '#diskon', hitungTotal);

    $(document).off('click', '#simpanPembelian').on('click', '#simpanPembelian', function () {
    var tgl  = $('#tgl').val();
    var nama = $('#namaPerusahaan').val();
    if (!tgl)  { alert('Tanggal wajib diisi!'); return; }
    if (!nama) { alert('Pilih supplier dulu!'); return; }

    var items = [];
    $('#tabledata tr').each(function () {
        items.push({
            kode    : $(this).find('td:eq(1)').text(),
            nama    : $(this).find('td:eq(2)').text(),
            satuan  : $(this).find('td:eq(3)').text(),
            harga   : $(this).find('.harga-raw').val(),
            qty     : $(this).find('td:eq(5)').text(),
            subtotal: $(this).find('.subtotal-raw').val()
        });
    });

    if (items.length === 0) { alert('Belum ada barang!'); return; }

    $.post('simpan_pembelian.php', {
        tgl            : tgl,
        nama_perusahaan: nama,
        contact_person : $('#contactPerson').val(),
        hp             : $('#phoneNum').val(),
        alamat         : $('#alamat').val(),
        keterangan     : $('#keterangan').val(),
        total          : $('#displayTotal').text().replace('Rp ', '').replace(/\./g, ''),
        diskon         : $('#diskon').val(),
        grandtotal     : $('#grandtotal').data('raw'),
        items          : JSON.stringify(items)
    }, function (res) {
        if (res.trim() === 'ok') {
            alert('Pembelian berhasil disimpan!');
            $("#isi").load('view_pembelian.php');
        } else {
            alert('Gagal: ' + res);
        }
    });
});

})();
</script>