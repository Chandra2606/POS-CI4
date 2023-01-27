<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalformeditLabel">Edit pemasok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pemasok/updatedata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Kode pemasok</label>
                    <input type="text" name="kdpem" id="kdpem" class="form-control form-control-sm" value="<?= $kdpem; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama pemasok</label>
                    <input type="text" name="namapem" id="namapem" class="form-control form-control-sm" required value="<?= $namapem; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" name="alamatpem" id="alamatpem" class="form-control form-control-sm" required value="<?= $alamatpem; ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">No Tlp</label>
                    <input type="text" name="notlp" id="notlp" class="form-control form-control-sm" required value="<?= $notlp; ?>">
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