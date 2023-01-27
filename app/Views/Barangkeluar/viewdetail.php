<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Harga Barang</th>
            <th>Jumlah</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($datadetail->getResultArray() as $r) :
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $r['id']; ?></td>
                <td><?= $r['namabrg']; ?></td>
                <td><?= $r['satuanbrg']; ?></td>
                <td><?= $r['hargajual']; ?></td>
                <td><?= $r['jml']; ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusitem('<?= $r['idbantu'] ?>','<?= $r['namabrg'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<script>
    function hapusitem(id, nama) {
        Swal.fire({
            title: 'Hapus Item ?',
            html: `Yakin menghapus data barang <strong>${nama}</strong> ?`,
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
                    url: "<?= site_url('barangmasuk/hapusItem') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataTempBarangMasuk();
                            kosong();
                        }
                    }
                });
            }
        })
    }
</script>