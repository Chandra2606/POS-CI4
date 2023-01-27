<?php

namespace App\Controllers;

use App\Models\Mpemasok;

class Pemasok extends BaseController
{
    public function __construct()
    {
        $this->varpemasok = new Mpemasok();
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolpemasok');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caripemasok');
            session()->set('caripemasok', $cari);
            redirect()->to('/pemasok/index');
        } else {
            $cari = session()->get('caripemasok');
        }
        $datapemasok = $cari ? $this->varpemasok->cariData($cari) : $this->varpemasok;
        $noHalaman = $this->request->getVar('page_pemasok') ? $this->request->getVar('page_pemasok') : 1;
        $data = [
            'datapemasok' => $datapemasok->paginate(10, 'pemasok'),
            'pager' => $this->varpemasok->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('pemasok/vpemasok', $data);
    }
    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $aksi = $this->request->getPost('aksi');
            $msg = [
                'data' => view('pemasok/modalformtambah', ['aksi' => $aksi])
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }
    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kdpem = $this->request->getVar('kdpem');
            $namapem = $this->request->getVar('namapem');
            $alamatpem = $this->request->getVar('alamatpem');
            $notlp = $this->request->getVar('notlp');
            $this->varpemasok->insert([
                'kdpem' => $kdpem,
                'namapem' => $namapem,
                'alamatpem' => $alamatpem,
                'notlp' => $notlp,
            ]);
            $msg = [
                'sukses' => 'pemasok berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kdpem = $this->request->getVar('kdpem');
            $this->varpemasok->delete($kdpem);
            $msg = [
                'sukses' => 'pemasok berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }
    function formedit()
    {
        if ($this->request->isAJAX()) {
            $kdpem = $this->request->getVar('kdpem');
            $ambildatapemasok = $this->varpemasok->find($kdpem);
            $data = [
                'kdpem' => $kdpem,
                'namapem' => $ambildatapemasok['namapem'],
                'alamatpem' => $ambildatapemasok['alamatpem'],
                'notlp' => $ambildatapemasok['notlp'],
            ];
            $msg = [
                'data' => view('pemasok/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }
    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kdpem = $this->request->getVar('kdpem');
            $namapem = $this->request->getVar('namapem');
            $alamat = $this->request->getVar('alamatpem');
            $notlp = $this->request->getVar('notlp');
            $this->varpemasok->update($kdpem, [
                'namapem' => $namapem,
                'alamatpem' => $alamat,
                'notlp' => $notlp,
            ]);
            $msg = [
                'sukses' => 'Data pemasok berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }
}
