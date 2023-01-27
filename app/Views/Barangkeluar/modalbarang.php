<div class="modal fade" id="modaltambahbarang" tabindex="-1" aria-labelledby="modaltambahbarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahbarangLabel">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan Barang</th>
                        <th>Harga Barang</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1;
                    foreach ($databarang as $row) :
                    ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['kdbrg']; ?></td>
                            <td><?= $row['namabrg']; ?></td>
                            <td><?= $row['satuanbrg']; ?></td>
                            <td><?= $row['hargabrg']; ?></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" title="Pilih Data" onclick="pilih('<?= $row['kdbrg'] ?>','<?= $row['namabrg'] ?>','<?= $row['satuanbrg'] ?>','<?= $row['hargabrg'] ?>')">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->

    <!-- /.card-footer-->
</div>
<div class="viewmodal" style="display: none;"></div>
</div>
</div>
</div>
<script>
    function pilih(kodebrg, namabrg, satua, hrg) {
        $('#kdbrg').val(kodebrg);
        $('#namabrg').val(namabrg);
        $('#satuanbrg').val(satua);
        $('#hargabrg').val(hrg);
        $('#modaltambahbarang').modal('hide');
    }
</script>