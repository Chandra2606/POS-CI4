<div class="modal fade" id="modaltambahpemasok" tabindex="-1" aria-labelledby="modaltambahpemasokLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahpemasokLabel">Tambah Pemasok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pemasok</th>
                        <th>Nama Pemasok</th>
                        <th>Alamat Pemasok</th>
                        <th>No Telpon</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1;
                    foreach ($datapemasok as $row) :
                    ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['kdpem']; ?></td>
                            <td><?= $row['namapem']; ?></td>
                            <td><?= $row['alamatpem']; ?></td>
                            <td><?= $row['notlp']; ?></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" title="Pilih Data" onclick="pilih('<?= $row['kdpem'] ?>','<?= $row['namapem'] ?>')">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
</div>
</div>
</div>
<script>
    function pilih(kode, nama) {
        $('#kdpem').val(kode);
        $('#namapem').val(nama);
        $('#modaltambahpemasok').modal('hide');
    }
</script>