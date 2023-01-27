<?php

namespace App\Controllers;

use App\Models\Mbarangmasuk;
use App\Models\Mpemasok;
use App\Models\Mbarang;

class Barangmasuk extends BaseController
{
    public function __construct()
    {
        $this->varbarangmasuk = new Mbarangmasuk();
        $this->varpemasok = new Mpemasok();
        $this->varbarang = new Mbarang();
    }
    public function index()
    {
        $tombolCaribarangmasuk = $this->request->getPost('tombolcaribarangmasuk');
        if (isset($tombolCaribarangmasuk)) {
            $cari = $this->request->getPost('caribarangmasuk');
            session()->set('caribarangmasuk', $cari);
            redirect()->to('/barangmasuk/index');
        } else {
            $cari = session()->get('caribarangmasuk');
        }
        $databarangmasuk = $cari ? $this->varbarangmasuk->cariData($cari) : $this->varbarangmasuk->join('detailmasuk', 'detailnofak=nofakmasuk')->join('pemasok', 'masukkdpem=kdpem')->join('barang', 'detailkdbrg=kdbrg');
        $noHalaman = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;
        $data = [
            'databarangmasuk' => $databarangmasuk->paginate(5, 'barangmasuk'),
            'pager' => $this->varbarangmasuk->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('barangmasuk/vdata', $data);
    }
    public function datapemasok()
    {
        $data = [
            'datapemasok' => $this->varpemasok->findAll()
        ];
        $msg = [
            'data' => view('barangmasuk/modalpemasok', $data)
        ];
        echo json_encode($msg);
    }
    public function databarang()
    {
        $data = [
            'databarang' => $this->varbarang->findAll()
        ];
        $msg = [
            'data' => view('barangmasuk/modalbarang', $data)
        ];
        echo json_encode($msg);
    }
    public function add()
    {
        return view('barangmasuk/formtambah');
    }
    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $tblTempbarangmasuk = $this->db->table('bantu');
            $queryHapus = $tblTempbarangmasuk->delete(['id' => $id]);
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
        $nofakmasuk = $this->request->getPost('nofakmasuk');
        // lakukan insert ke temp barangmasuk
        $tblTempbarangmasuk = $this->db->table('bantu');
        $insertData = [
            'idbrg' => $kdbrg,
            'qty' => $jml,
            'hrg' => $hrg,
            'faktur' => $nofakmasuk
        ];
        $tblTempbarangmasuk->insert($insertData);
        $msg = ['sukses' => 'berhasil'];
        echo json_encode($msg);
    }
    public function dataDetail()
    {
        $nofakmasuk = $this->request->getVar('nofakmasuk');
        $tempbarangmasuk = $this->db->table('bantu');
        $queryTampil = $tempbarangmasuk->select('id as idbantu,idbrg as id, namabrg,satuanbrg,hrg as hargajual, qty as jml')->join('barang', 'idbrg=kdbrg')->where('faktur', $nofakmasuk);
        $data = [
            'datadetail' => $queryTampil->get(),
        ];
        $msg = [
            'data' => view('barangmasuk/viewdetail', $data)
        ];
        echo json_encode($msg);
    }
    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $nofakmasuk = $this->request->getVar('nofakmasuk');
            $masukkdpem = $this->request->getVar('masukkdpem');
            $validation = \Config\Services::validation();
            $doValid = $this->validate([
                'nofakmasuk' => [
                    'label' => 'No Faktur',
                    'rules' => 'required|is_unique[produk.nofakmasuk]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada,coba yang lain'
                    ]
                ],
                'masukkdpem' => [
                    'label' => 'Kode Pemasok',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errornofakmasuk' => $validation->getError('nofakmasuk'),
                        'errormasukkdpem' => $validation->getError('masukkdpem')
                    ]
                ];
            } else {
                $this->produk->insert([
                    'nofakmasuk' => $nofakmasuk,
                    'masukkdpem' => $masukkdpem
                ]);
                $msg = ['sukses' => 'Barang baru berhasil ditambahkan'];
            }
            echo json_encode($msg);
        }
    }
    public function selesaitransaksi()
    {
        $nofakmasuk = $this->request->getPost('nofakmasuk');
        $tanggal = $this->request->getPost('tanggal');
        $kdpem = $this->request->getPost('kdpem');
        $cekDataTemp = $this->db->table('bantu')->where('faktur', $nofakmasuk)->get();
        if (strlen($nofakmasuk) > 0) {
            if ($cekDataTemp->getNumRows() > 0) {
                $tblBarangMasuk = $this->db->table('barangmasuk');
                $tblDetailMasuk = $this->db->table('detailmasuk');
                $tblBantu = $this->db->table('bantu');
                //Simpan ke table barangmasuk
                $tblBarangMasuk->insert([
                    'nofakmasuk' => $nofakmasuk,
                    'tglmasuk' => $tanggal,
                    'masukkdpem' => $kdpem
                ]);
                // ambil data bantu
                $ambilDataTemp = $tblBantu->getWhere(['faktur' => $nofakmasuk]);
                $fieldDetailBarangMasuk = [];
                foreach ($ambilDataTemp->getResultArray() as $row) {
                    $fieldDetailBarangMasuk[] = [
                        'detailnofak' => $row['faktur'],
                        'detailkdbrg' => $row['idbrg'],
                        'detailqty' => $row['qty'],
                        'detailhrgbrg' => $row['hrg'],
                    ];
                }
                $tblDetailMasuk->insertBatch($fieldDetailBarangMasuk);
                // Hapus data pada table bantu
                $tblBantu->emptyTable();
                session()->setFlashdata('error', '<div class="alert alert-success alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
 Transaksi berhasil disimpan...
 </div>');
                return redirect()->to('/barangmasuk/add');
            } else {
                session()->setFlashdata('error', '<div class="alert alert-danger alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-ban"></i> Error!</h5>
 Maaf Item belum ditambahkan, silahkan ditambahkan terlebih dahulu...
 </div>');
                return redirect()->to('/barangmasuk/add');
            }
        } else {
            session()->setFlashdata('error', '<div class="alert alert-danger alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h5><i class="icon fas fa-ban"></i> Error!</h5>
 Maaf Nofaktur belum diinputkan...
 </div>');
            return redirect()->to('/barangmasuk/add');
        }
    }
}
