<?= $this->extend('template/menu') ?>
<?= $this->section('judul') ?>
<h3>Manajemen Data Barang Keluar</h3>
<?= $this->endSection() ?>
<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-primary" onclick="window.location='<?= site_url('barangkeluar/add') ?>'">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?= form_open('barangkeluar/index') ?>
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Kode/Nama Barang" name="caribarangkeluar" autofocus>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="tombolcaribarangkeluar">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <?= form_close(); ?>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No faktur</th>
                        <th>Tanggal keluar</th>
                        <th>Nama pelanggan</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang(Rp)</th>
                        <th>Stok</th>
                        <!-- <th>#</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1 + (($nohalaman - 1) * 5);
                    foreach ($databarangkeluar as $row) :
                    ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['nofakkeluar']; ?></td>
                            <td><?= $row['tglkeluar']; ?></td>
                            <td><?= $row['namaplg']; ?></td>
                            <td><?= $row['namabrg']; ?></td>
                            <td style="text-align: right;"><?= number_format($row['hargabrg'], 2, ",", "."); ?></td>
                            <td style="text-align: right;"><?= number_format($row['stokbrg'], 0, ",", "."); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <div>
                    <?= $pager->links('barangkeluar', 'paging_data'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>