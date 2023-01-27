<?= $this->extend('template/menu') ?>
<?= $this->section('judul') ?>
<h3><i class="fa fa-table"></i> Tambah Barang Masuk</h3>
<?= $this->endSection() ?>
<?= $this->section('isi') ?>
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-warning" onclick="window.location='<?= site_url('barangmasuk/index') ?>'">
                <i class="fa fa-backward"></i> Kembali
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
        <?= session()->getFlashdata('error'); ?>
        <?= form_open('barangmasuk/selesaitransaksi', ['class' => 'formsimpanbarangmasuk', 'onsubmit' => 'return selesaitransaksi();']) ?>
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nofaktur">Faktur</label>
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="nofakmasuk" id="nofakmasuk" value="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="namapem">Pemasok</label>
                    <div class="input-group mb-3">
                        <input type="text" value="-" class="form-control form-control-sm" name="namapem" id="namapem" readonly>
                        <input type="hidden" name="kdpem" id="kdpem" value="0">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary tombolTambahpemasok">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="kdbrg">Kode Barang</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" name="kdbrg" id="kdbrg">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary tombolTambahbarang">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" style="font-weight: bold; font-size:16pt;" class="form-control form-control-sm" name="namabrg" id="namabrg" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Satuan Barang</label>
                    <input type="text" style="font-weight: bold; font-size:16pt;" class="form-control form-control-sm" name="satuanbrg" id="satuanbrg" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="jml">Harga Barang</label>
                    <input type="text" class="form-control form-control-sm" name="hargabrg" id="hargabrg" value="1">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="text" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">#</label><br>
                    <button type="submit" class="btn btn-sm btn-success tombolSimpanTemp">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dataTemp">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success">
                    Selesai Transaksi
                </button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<div class="viewmodall" style="display: none;"></div>\
<script>
    function selesaitransaksi() {
        pesan = confirm('Yakin Simpan Transaksi ?');
        if (pesan) {
            return true;
        } else {
            return false;
        }
    }
    $(document).ready(function() {
        dataTempBarangMasuk();
        $('.tombolSimpanTemp').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= site_url('barangmasuk/simpanTemp') ?>",
                data: {
                    nofakmasuk: $('#nofakmasuk').val(),
                    kdbrg: $('#kdbrg').val(),
                    harga: $('#hargabrg').val(),
                    jumlah: $('#jumlah').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses == 'berhasil') {
                        dataTempBarangMasuk();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $('.tombolTambahpemasok').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('barangmasuk/datapemasok') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 0
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahpemasok').on('shown.bs.modal', function(event) {
                            $('#kdpem').focus();
                        });
                        $('#modaltambahpemasok').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $('.tombolTambahbarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('barangmasuk/databarang') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 0
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewmodall').html(response.data).show();
                        $('#modaltambahbarang').on('shown.bs.modal', function(event) {
                            $('#kdbrg').focus();
                        });
                        $('#modaltambahbarang').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $('.tombolSimpanbarangmasuk').click(function(e) {
            e.preventDefault();
            let form = $('.formsimpanbarangmasuk')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "<?= site_url('barangmasuk/simpandata') ?>",
                data: data,
                dataType: "json",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.tombolSimpanbarang').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpanbarang').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpanbarangmasuk').html('Simpan');
                    $('.tombolSimpanbarangmasuk').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let dataError = response.error;
                        if (dataError.errorKodeBarcode) {
                            $('.errornofakmasuk').html(dataError.errorKodeBarcode).show();
                            $('#nofakmasuk').addClass('is-invalid');
                        } else {
                            $('.errornofakmasuk').fadeOut();
                            $('#nofakmasuk').removeClass('is-invalid');
                            $('#nofakmasuk').addClass('is-valid');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: response.sukses,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
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
        });
    });

    function kosong() {
        $('#kdbrg').val('');
        $('#namabrg').val('');
        $('#hargabrg').val('');
        $('#satuanbrg').val('');
        $('#jumlah').val('');
    }

    function dataTempBarangMasuk() {
        $.ajax({
            type: "post",
            url: "<?= site_url('barangmasuk/dataDetail') ?>",
            data: {
                nofakmasuk: $('#nofakmasuk').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataTemp').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.dataTemp').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection() ?>