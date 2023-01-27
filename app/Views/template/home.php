<?= $this->extend('template/menu') ?>
<?= $this->section('judul') ?>
<h1>INI JUDUL</h1>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="alert alert-info alert dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h5><i class="icon fas fa-info"></i>Selamat Datang</h5>
</div>
<?= $this->endSection() ?>