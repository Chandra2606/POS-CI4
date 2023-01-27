<div class="modal fade" id="modaltambahbarang" tabindex="-1" aria- labelledby="modaltambahbarangLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahbarangLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('barang/simpandata', ['class' => 'formsimpan']) ?>
            <input type="hidden" name="aksi" id="aksi" value="<?= $aksi; ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label form="">Kode Barang</label>
                    <input type="text" name="kdbrg" id="kdbrg" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" name="namabrg" id="namabrg" class="form-control form-
control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Satuan Barang</label>
                    <input type="text" name="satuanbrg" id="satuanbrg" class="form-control form-
control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Harga Barang</label>
                    <input type="text" name="hargabrg" id="hargabrg" class="form-control form-
control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Stok Barang</label>
                    <input type="text" name="stokbrg" id="stokbrg" class="form-control form-
control-sm" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.formsimpan').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function(e) {
                $('.tombolSimpan').prop('disabled', true);
                $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                let aksi = $('#aksi').val();
                if (response.sukses) {
                    if (aksi == 0) {
                        Swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        tampilbarang();
                        $('#modaltambahbarang').modal('hide');
                    }
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });
});

function hapus(kdbrg, namabrg, satuanbrg, hargabrg, stokbrg) {
    Swal.fire({
        title: 'Hapus Barang',
        html: `Yakin hapus nama Barang <strong>${namabrg}</strong> ini ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('barang/hapus') ?>",
                data: {
                    kdbrg: kdbrg
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    })
}

function edit(kdbrg) {
    $.ajax({
        type: "post",
        url: "<?= site_url('barang/formedit') ?>",
        data: {
            kdbrg: kdbrg
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modalformedit').on('shown.bs.modal', function(event) {
                    $('#namabrg').focus();
                });
                $('#modalformedit').modal('show');
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
</script>