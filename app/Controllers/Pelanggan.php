<?php

namespace App\Controllers;

use App\Models\Mpelanggan;

class Pelanggan extends BaseController
{
    public function __construct()
    {
        $this->varpelanggan = new Mpelanggan();
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolpelanggan');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caripelanggan');
            session()->set('caripelanggan', $cari);
            redirect()->to('/pelanggan/index');
        } else {
            $cari = session()->get('caripelanggan');
        }
        $datapelanggan = $cari ? $this->varpelanggan->cariData($cari) : $this->varpelanggan;
        $noHalaman = $this->request->getVar('page_pelanggan') ? $this->request->getVar('page_pelanggan') : 1;
        $data = [
            'datapelanggan' => $datapelanggan->paginate(10, 'pelanggan'),
            'pager' => $this->varpelanggan->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('pelanggan/vpelanggan', $data);
    }
    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $aksi = $this->request->getPost('aksi');
            $msg = [
                'data' => view('pelanggan/modalformtambah', ['aksi' => $aksi])
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }
    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getVar('kdplg');
            $namaplg = $this->request->getVar('namaplg');
            $alamat = $this->request->getVar('alamat');
            $notlp = $this->request->getVar('notlp');
            $this->varpelanggan->insert([
                'kdplg' => $kdplg,
                'namaplg' => $namaplg,
                'alamatplg' => $alamat,
                'notlp' => $notlp,
            ]);
            $msg = [
                'sukses' => 'pelanggan berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getVar('kdplg');
            $this->varpelanggan->delete($kdplg);
            $msg = [
                'sukses' => 'pelanggan berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }
    function formedit()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getVar('kdplg');
            $ambildatapelanggan = $this->varpelanggan->find($kdplg);
            $data = [
                'kdplg' => $kdplg,
                'namaplg' => $ambildatapelanggan['namaplg'],
                'alamatplg' => $ambildatapelanggan['alamatplg'],
                'notlp' => $ambildatapelanggan['notlp'],
            ];
            $msg = [
                'data' => view('pelanggan/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }
    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getVar('kdplg');
            $namaplg = $this->request->getVar('namaplg');
            $alamat = $this->request->getVar('alamat');
            $notlp = $this->request->getVar('notlp');
            $this->varpelanggan->update($kdplg, [
                'namaplg' => $namaplg,
                'alamatplg' => $alamat,
                'notlp' => $notlp,
            ]);
            $msg = [
                'sukses' => 'Data pelanggan berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }
}
