<?php

namespace App\Controllers;

use App\Models\Mbarang;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->varbarang = new Mbarang();
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolbarang');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caribarang');
            session()->set('caribarang', $cari);
            redirect()->to('/barang/index');
        } else {
            $cari = session()->get('caribarang');
        }
        $databarang = $cari ? $this->varbarang->cariData($cari) : $this->varbarang;
        $noHalaman = $this->request->getVar('page_barang') ? $this->request->getVar('page_barang') : 1;
        $data = [
            'databarang' => $databarang->paginate(10, 'barang'),
            'pager' => $this->varbarang->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('barang/vbarang', $data);
    }
    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $aksi = $this->request->getPost('aksi');
            $msg = [
                'data' => view('barang/modalformtambah', ['aksi' => $aksi])
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }
    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kdbrg = $this->request->getVar('kdbrg');
            $namabrg = $this->request->getVar('namabrg');
            $satuanbrg = $this->request->getVar('satuanbrg');
            $hargabrg = $this->request->getVar('hargabrg');
            $stokbrg = $this->request->getVar('stokbrg');
            $this->varbarang->insert([
                'kdbrg' => $kdbrg,
                'namabrg' => $namabrg,
                'satuanbrg' => $satuanbrg,
                'hargabrg' => $hargabrg,
                'stokbrg' => $stokbrg
            ]);
            $msg = [
                'sukses' => 'Barang berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kdbrg = $this->request->getVar('kdbrg');
            $this->varbarang->delete($kdbrg);
            $msg = [
                'sukses' => 'Barang berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }
    function formedit()
    {
        if ($this->request->isAJAX()) {
            $kdbrg = $this->request->getVar('kdbrg');
            $ambildatabarang = $this->varbarang->find($kdbrg);
            $data = [
                'kdbrg' => $kdbrg,
                'namabrg' => $ambildatabarang['namabrg'],
                'satuanbrg' => $ambildatabarang['satuanbrg'],
                'hargabrg' => $ambildatabarang['hargabrg'],
                'stokbrg' => $ambildatabarang['stokbrg'],
            ];
            $msg = [
                'data' => view('barang/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }
    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kdbrg = $this->request->getVar('kdbrg');
            $namabrg = $this->request->getVar('namabrg');
            $satuanbrg = $this->request->getVar('satuanbrg');
            $hargabrg = $this->request->getVar('hargabrg');
            $stokbrg = $this->request->getVar('stokbrg');
            $this->varbarang->update($kdbrg, [
                'namabrg' => $namabrg,
                'satuanbrg' => $satuanbrg,
                'hargabrg' => $hargabrg,
                'stokbrg' => $stokbrg
            ]);
            $msg = [
                'sukses' => 'Data Barang berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }
}