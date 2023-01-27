<?= $this->extend('template/main') ?>
<?= $this->section('menu') ?>
<li class="nav-item">

</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            MASTER
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url('barang/index') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url('pelanggan/index') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pelanggan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url('pemasok/index') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pemasok</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            TRANSAKSI
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= site_url('Barangmasuk/index') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Barang Masuk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= site_url('Barangkeluar/index') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Barang Keluar</p>
            </a>
        </li>

    </ul>
</li>
<?= $this->endSection() ?>