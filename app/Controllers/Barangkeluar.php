<?php

namespace App\Controllers;

use App\Models\Mbarangkeluar;
use App\Models\Mpelanggan;
use App\Models\Mbarang;

class barangkeluar extends BaseController
{
    public function __construct()
    {
        $this->varbarangkeluar = new Mbarangkeluar();
        $this->varpelanggan = new Mpelanggan();
        $this->varbarang = new Mbarang();
    }
    public function index()
    {
        $tombolCaribarangkeluar = $this->request->getPost('tombolcaribarangkeluar');
        if (isset($tombolCaribarangkeluar)) {
            $cari = $this->request->getPost('caribarangkeluar');
            session()->set('caribarangkeluar', $cari);
            redirect()->to('/barangkeluar/index');
        } else {
            $cari = session()->get('caribarangkeluar');
        }
        $databarangkeluar = $cari ? $this->varbarangkeluar->cariData($cari) : $this->varbarangkeluar->join('detailkeluar', 'detailnofak=nofakkeluar')->join('pelanggan', 'keluarkdplg=kdplg')->join('barang', 'detailkdbrg=kdbrg');
        $noHalaman = $this->request->getVar('page_barangkeluar') ? $this->request->getVar('page_barangkeluar') : 1;
        $data = [
            'databarangkeluar' => $databarangkeluar->paginate(5, 'barangkeluar'),
            'pager' => $this->varbarangkeluar->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('barangkeluar/vdata', $data);
    }
    public function datapelanggan()
    {
        $data = [
            'datapelanggan' => $this->varpelanggan->findAll()
        ];
        $msg = [
            'data' => view('barangkeluar/modalpelanggan', $data)
        ];
        echo json_encode($msg);
    }
    public function databarang()
    {
        $data = [
            'databarang' => $this->varbarang->findAll()
        ];
        $msg = [
            'data' => view('barangkeluar/modalbarang', $data)
        ];
        echo json_encode($msg);
    }
    public function add()
    {
        return view('barangkeluar/formtambah');
    }
    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $tblTempbarangkeluar = $this->db->table('bantu');
            $queryHapus = $tblTempbarangkeluar->delete(['id' => $id]);
            if ($queryHapus) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
                echo json_encode($msg);
            }
        }
    }
    public function simpanTemp()
    {
        // if ($this->request->isAJAX()) {
        $kdbrg = $this->request->getPost('kdbrg');
        $jml = $this->request->getPost('jumlah');
        $hrg = $this->request->getPost('harga');
        $nofakkeluar = $this->request->getPost('nofakkeluar');
        // lakukan insert ke temp barangkeluar
        $tblTempbarangkeluar = $this->db->table('bantu');
        $insertData = [
            'idbrg' => $kdbrg,
            'qty' => $jml,
            'hrg' => $hrg,
            'faktur' => $nofakkeluar
        ];
        $tblTempbarangkeluar->insert($insertData);
        $msg = ['sukses' => 'berhasil'];
        echo json_encode($msg);
    }
    public function dataDetail()
    {
        $nofakkeluar = $this->request->getVar('nofakkeluar');
        $tempbarangkeluar = $this->db->table('bantu');
        $queryTampil = $tempbarangkeluar->select('id as idbantu,idbrg as id, namabrg,satuanbrg,hrg as hargajual, qty as jml')->join('barang', 'idbrg=kdbrg')->where('faktur', $nofakkeluar);
        $data = [
            'datadetail' => $queryTampil->get(),
        ];
        $msg = [
            'data' => view('barangkeluar/viewdetail', $data)
        ];
        echo json_encode($msg);
    }
    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $nofakkeluar = $this->request->getVar('nofakkeluar');
            $keluarkdplg = $this->request->getVar('keluarkdplg');
            $validation = \Config\Services::validation();
            $doValid = $this->validate([
                'nofakkeluar' => [
                    'label' => 'No Faktur',
                    'rules' => 'required|is_unique[produk.nofakkeluar]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada,coba yang lain'
                    ]
                ],
                'keluarkdplg' => [
                    'label' => 'Kode pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errornofakkeluar' => $validation->getError('nofakkeluar'),
                        'errorkeluarkdplg' => $validation->getError('keluarkdplg')
                    ]
                ];
            } else {
                $this->produk->insert([
                    'nofakkeluar' => $nofakkeluar,
                    'keluarkdplg' => $keluarkdplg
                ]);
                $msg = ['sukses' => 'Barang baru berhasil ditambahkan'];
            }
            echo json_encode($msg);
        }
    }
    public function selesaitransaksi()
    {
        $nofakkeluar = $this->request->getPost('nofakkeluar');
        $tanggal = $this->request->getPost('tanggal');
        $kdplg = $this->request->getPost('kdplg');
        $cekDataTemp = $this->db->table('bantu')->where('faktur', $nofakkeluar)->get();
        if (strlen($nofakkeluar) > 0) {
            if ($cekDataTemp->getNumRows() > 0) {
                $tblbarangkeluar = $this->db->table('barangkeluar');
                $tblDetailkeluar = $this->db->table('detailkeluar');
                $tblBantu = $this->db->table('bantu');
                //Simpan ke table barangkeluar
                $tblbarangkeluar->insert([
                    'nofakkeluar' => $nofakkeluar,
                    'tglkeluar' => $tanggal,
                    'keluarkdplg' => $kdplg
                ]);
                // ambil data bantu
                $ambilDataTemp = $tblBantu->getWhere(['faktur' => $nofakkeluar]);
                $fieldDetailbarangkeluar = [];
                foreach ($ambilDataTemp->getResultArray() as $row) {
                    $fieldDetailbarangkeluar[] = [
                        'detailnofak' => $row['faktur'],
                        'detailkdbrg' => $row['idbrg'],
                        'detailqty' => $row['qty'],
                        'detailhrgbrg' => $row['hrg'],
                    ];
                }
                $tblDetailkeluar->insertBatch($fieldDetailbarangkeluar);
                // Hapus data pada table bantu
                $tblBantu->emptyTable();
                session()->setFlashdata('error', '<div class="alert alert-success alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
 Transaksi berhasil disimpan...
 </div>');
                return redirect()->to('/barangkeluar/add');
            } else {
                session()->setFlashdata('error', '<div class="alert alert-danger alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-ban"></i> Error!</h5>
 Maaf Item belum ditambahkan, silahkan ditambahkan terlebih dahulu...
 </div>');
                return redirect()->to('/barangkeluar/add');
            }
        } else {
            session()->setFlashdata('error', '<div class="alert alert-danger alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-ban"></i> Error!</h5>
 Maaf Nofaktur belum diinputkan...
 </div>');
            return redirect()->to('/barangkeluar/add');
        }
    }
}
