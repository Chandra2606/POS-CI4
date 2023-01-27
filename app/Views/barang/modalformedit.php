<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalformeditLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('barang/updatedata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" name="kdbrg" id="kdbrg" class="form-control form-control-sm" value="<?= $kdbrg; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" name="namabrg" id="namabrg" class="form-control form-control-sm" required value="<?= $namabrg; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Satuan Barang</label>
                    <input type="text" name="satuanbrg" id="satuanbrg" class="form-control form-control-sm" required value="<?= $satuanbrg; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Harga Barang</label>
                    <input type="text" name="hargabrg" id="hargabrg" class="form-control form-control-sm" required value="<?= $hargabrg; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Stok Barang</label>
                    <input type="text" name="stokbrg" id="stokbrg" class="form-control form-control-sm" required value="<?= $stokbrg; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary tombolUpdate">Update</button>
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
                    $('.tombolUpdate').prop('disabled', true);
                    $('.tombolUpdate').html('<i class="fa fa-spin fa-spinner"></i>')
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>