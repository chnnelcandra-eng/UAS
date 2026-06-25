<?php include 'koneksi.php'; ?>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="p-3 mb-3 text-white rounded" style="background-color: #2e7d32;">
        <strong>Supplier</strong>
    </div>

    <!-- TOMBOL TAMBAH -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalSupplier" onclick="resetForm()">
        + Tambah Supplier
    </button>

    <!-- TABEL -->
    <table class="table table-bordered table-striped">
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
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id ASC");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td>
                    <button class="btn btn-warning btn-sm"
                        onclick="editSupplier(
                            <?= $row['id'] ?>,
                            '<?= addslashes($row['nama_perusahaan']) ?>',
                            '<?= addslashes($row['contact_person']) ?>',
                            '<?= addslashes($row['hp']) ?>',
                            '<?= addslashes($row['alamat']) ?>',
                            '<?= addslashes($row['keterangan']) ?>'
                        )"
                        data-bs-toggle="modal" data-bs-target="#modalSupplier">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm"
                        onclick="hapusSupplier(<?= $row['id'] ?>)">
                        Hapus
                    </button>
                </td>
                <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                <td><?= htmlspecialchars($row['contact_person']) ?></td>
                <td><?= htmlspecialchars($row['hp']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalSupplier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2e7d32; color: white;">
                <h5 class="modal-title" id="modalTitle">Tambah Supplier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="supplierId">
                <div class="mb-3">
                    <label class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="namaPerusahaan">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" id="contactPerson">
                </div>
                <div class="mb-3">
                    <label class="form-label">HP</label>
                    <input type="text" class="form-control" id="hp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="simpanSupplier()">Simpan</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function resetForm() {
    $('#modalTitle').text('Tambah Supplier');
    $('#supplierId').val('');
    $('#namaPerusahaan').val('');
    $('#contactPerson').val('');
    $('#hp').val('');
    $('#alamat').val('');
    $('#keterangan').val('');
}

function editSupplier(id, nama, cp, hp, alamat, ket) {
    $('#modalTitle').text('Edit Supplier');
    $('#supplierId').val(id);
    $('#namaPerusahaan').val(nama);
    $('#contactPerson').val(cp);
    $('#hp').val(hp);
    $('#alamat').val(alamat);
    $('#keterangan').val(ket);
}

function simpanSupplier() {
    const id   = $('#supplierId').val();
    const nama = $('#namaPerusahaan').val().trim();

    if (nama === '') {
        alert('Nama Perusahaan wajib diisi!');
        return;
    }

    $.post('supplier_action.php', {
        aksi           : id ? 'update' : 'insert',
        id             : id,
        nama_perusahaan: nama,
        contact_person : $('#contactPerson').val(),
        hp             : $('#hp').val(),
        alamat         : $('#alamat').val(),
        keterangan     : $('#keterangan').val()
    }, function(res) {
        if (res.trim() === 'ok') {
            bootstrap.Modal.getInstance(document.getElementById('modalSupplier')).hide();
            $("#isi").load('supplier.php');
        } else {
            alert('Gagal: ' + res);
        }
    });
}

function hapusSupplier(id) {
    if (!confirm('Yakin hapus supplier ini?')) return;
    $.post('supplier_action.php', { aksi: 'delete', id: id }, function(res) {
        if (res.trim() === 'ok') {
            $("#isi").load('supplier.php');
        } else {
            alert('Gagal: ' + res);
        }
    });
}
</script>