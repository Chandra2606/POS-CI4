<?= $this->extend('template/menu') ?>
<?= $this->section('judul') ?>
<H1> DATA PELANGGAN <h1>
        <?= $this->endSection() ?>
        <?= $this->section('isi') ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-sm btn-primary tombolTambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card- widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form method="POST" action="/pelanggan/index">
                        <?= csrf_field(); ?>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari Nama pelanggan" name="caripelanggan" autofocus value="<?= $cari; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="tombolpelanggan">Cari</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode pelanggan</th>
                                <th>Nama pelanggan</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1 + (($nohalaman - 1) * 10);
                            foreach ($datapelanggan as $row) :
                            ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row['kdplg']; ?></td>
                                    <td><?= $row['namaplg']; ?></td>
                                    <td><?= $row['alamatplg']; ?></td>
                                    <td><?= $row['notlp']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus pelanggan" onclick="hapus('<?= $row['kdplg'] ?>','<?= $row['namaplg'] ?>')">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm" title="Edit pelanggan" onclick="edit('<?= $row['kdplg'] ?>')">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="float-center">
                        <?= $pager->links('pelanggan', 'paging_data'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="viewmodal" style="display: none;"></div>
        <script>
            $(document).ready(function() {
                $('.tombolTambah').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?= site_url('pelanggan/formTambah') ?>",
                        dataType: "json",
                        type: 'post',
                        data: {
                            aksi: 0
                        },
                        success: function(response) {
                            if (response.data) {
                                $('.viewmodal').html(response.data).show();
                                $('#modaltambahpelanggan').on('shown.bs.modal', function(event) {
                                    $('#kdplg').focus();
                                });
                                $('#modaltambahpelanggan').modal('show');
                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                });
            });

            function hapus(kdplg, namaplg, alamatplg, notlp) {
                Swal.fire({
                    title: 'Hapus pelanggan',
                    html: `Yakin hapus nama pelanggan <strong>${namaplg}</strong> ini ?`,
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
                            url: "<?= site_url('pelanggan/hapus') ?>",
                            data: {
                                kdplg: kdplg
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

            function edit(kdplg) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('pelanggan/formedit') ?>",
                    data: {
                        kdplg: kdplg
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.data) {
                            $('.viewmodal').html(response.data).show();
                            $('#modalformedit').on('shown.bs.modal', function(event) {
                                $('#namaplg').focus();
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
        <?= $this->endSection() ?>