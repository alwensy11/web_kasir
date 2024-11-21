<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class Produk extends BaseController
{
    // Deklarasi properti untuk menyimpan instance dari model Produk
    protected $produkmodel;

    // Konstruktor untuk menginisialisasi model Produk
    public function __construct()
    {
        $this->produkmodel = new ProdukModel;  // Membuat instance dari ProdukModel
    }

    // Fungsi untuk menampilkan halaman utama produk
    public function index()
    {
        return view('v_produk');  // Mengembalikan tampilan view 'v_produk' (halaman produk)
    }

    // Fungsi untuk mengambil semua data produk dan mengembalikannya dalam format JSON
    public function tampil_produk()
    {
        $produk = $this->produkmodel->findAll();  // Mengambil semua data produk dari database
        return $this->response->setJSON([  // Mengembalikan response dalam format JSON
            'status' => 'success',
            'produk' => $produk  // Mengirim data produk dalam response
        ]);
    }

    public function simpan_produk()
    {
        // Memuat library upload menggunakan service
        $upload = \Config\Services::upload();

        // Menyusun konfigurasi upload
        $config['uploadPath'] = WRITEPATH . 'uploads/';  // Pastikan folder 'uploads' ada dan dapat ditulis
        $config['allowedTypes'] = 'gif|jpg|png|jpeg';    // Format gambar yang diperbolehkan
        $config['maxSize'] = 2048;                         // Maksimal ukuran file 2MB

        // Menginisialisasi konfigurasi
        $upload->initialize($config);

        // Mengecek apakah ada file gambar yang diupload
        if ($this->request->getFile('gambar')->isValid()) {
            $file = $this->request->getFile('gambar');
            if (!$file->hasMoved()) {
                // Proses upload gambar
                $fileName = $file->getName(); // Mendapatkan nama file gambar
                $file->move(WRITEPATH . 'uploads/', $fileName); // Menyimpan gambar ke folder uploads
            } else {
                // Jika file sudah dipindahkan
                return $this->response->setJSON(['status' => 'error', 'errors' => 'File sudah dipindahkan.']);
            }
        } else {
            // Jika tidak ada gambar yang diupload
            $fileName = ''; // Gambar kosong
        }

        // Menyimpan data produk ke database
        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'gambar' => $fileName, // Menyimpan nama file gambar
        ];

        $produkModel = new ProdukModel();
        $insert = $produkModel->insert($data);

        if ($insert) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'errors' => 'Gagal menyimpan produk']);
        }
    }

    // Fungsi untuk mengambil data produk berdasarkan ID
    public function tampil_by_id($id)
    {
        $produk = $this->produkmodel->find($id);  // Mengambil produk berdasarkan ID

        // Memeriksa apakah produk ditemukan
        if ($produk) {
            // Mengembalikan data produk dalam format JSON jika ditemukan
            return $this->response->setJSON([
                'status' => 'success',
                'produk' => $produk  // Data produk yang ditemukan
            ]);
        } else {
            // Mengembalikan response error jika produk tidak ditemukan
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'  // Pesan jika produk tidak ditemukan
            ]);
        }
    }

    // Fungsi untuk memperbarui data produk yang sudah ada
    public function update()
    {
        // Mengakses layanan validasi untuk memvalidasi inputan
        $validation = \Config\Services::validation();

        // Menetapkan aturan validasi untuk inputan
        $validation->setRules([
            'nama_produk' => 'required',  // Nama produk wajib diisi
            'harga' => 'required|decimal',  // Harga produk wajib diisi dan harus angka desimal
            'stok' => 'required|integer'   // Stok produk wajib diisi dan harus angka bulat
        ]);

        // Memeriksa apakah inputan valid
        if (!$validation->withRequest($this->request)->run()) {
            // Jika tidak valid, mengembalikan response error beserta pesan kesalahan
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),  // Mengambil pesan error dari validasi
            ]);
        }

        // Menyiapkan data yang akan diperbarui
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok')
        ];

        // Mengambil ID produk dari inputan
        $id = $this->request->getVar('id');

        // Memperbarui data produk berdasarkan ID menggunakan model
        $this->produkmodel->update($id, $data);

        // Mengembalikan response sukses jika data berhasil diperbarui
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data produk berhasil diperbarui',  // Pesan sukses
        ]);
    }

    // Fungsi untuk menghapus data produk berdasarkan ID
    public function hapus_produk($id)
    {
        // Menghapus produk berdasarkan ID menggunakan model
        $this->produkmodel->delete($id);

        // Mengembalikan response sukses jika data berhasil dihapus
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data produk berhasil dihapus.'  // Pesan sukses
        ]);
    }
}
