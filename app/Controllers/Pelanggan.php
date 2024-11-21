<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    // Deklarasi properti untuk menyimpan instance dari model Produk
    protected $pelangganmodel;

    // Konstruktor untuk menginisialisasi model Produk
    public function __construct()
    {
        $this->pelangganmodel = new PelangganModel();  // Membuat instance dari ProdukModel
    }

    // Fungsi untuk menampilkan halaman utama produk
    public function index()
    {
        return view('v_pelanggan');  // Mengembalikan tampilan view 'v_produk' (halaman produk)
    }

    // Fungsi untuk mengambil semua data produk dan mengembalikannya dalam format JSON
    public function tampil_pelanggan()
    {
        $pelanggan = $this->pelangganmodel->findAll();  // Mengambil semua data produk dari database
        return $this->response->setJSON([  // Mengembalikan response dalam format JSON
            'status' => 'success',
            'produk' => $pelanggan  // Mengirim data produk dalam response
        ]);
    }

    public function simpan_pelanggan()
    {

        // Menyimpan data produk ke database
        $data = [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat' => $this->request->getPost('alamat'),
            'nomer_telepon' => $this->request->getPost('nomer_telepon'),
        ];

        $pelangganModel = new PelangganModel();
        $insert = $pelangganModel->insert($data);

        if ($insert) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'errors' => 'Gagal menyimpan produk']);
        }
    }

    // Fungsi untuk mengambil data produk berdasarkan ID
    public function tampil_by_id($id)
    {
        $pelanggan = $this->pelangganmodel->find($id);  // Mengambil produk berdasarkan ID

        // Memeriksa apakah produk ditemukan
        if ($pelanggan) {
            // Mengembalikan data produk dalam format JSON jika ditemukan
            return $this->response->setJSON([
                'status' => 'success',
                'pelanggan' => $pelanggan  // Data produk yang ditemukan
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
    public function update_pelanggan()
    {

        // Menyiapkan data yang akan diperbarui
        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat' => $this->request->getVar('alamat'),
            'nomer_telepon' => $this->request->getVar('nomer_telepon')
        ];

        // Mengambil ID produk dari inputan
        $id = $this->request->getVar('id_pelanggan');

        // Memperbarui data produk berdasarkan ID menggunakan model
        $this->pelangganmodel->update($id, $data);

        // Mengembalikan response sukses jika data berhasil diperbarui
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pelanggan berhasil diperbarui',  // Pesan sukses
        ]);
    }

    // Fungsi untuk menghapus data produk berdasarkan ID
    public function hapus_pelanggan($id)
    {
        // Menghapus produk berdasarkan ID menggunakan model
        $this->pelangganmodel->delete($id);

        // Mengembalikan response sukses jika data berhasil dihapus
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pelanggan berhasil dihapus.'  // Pesan sukses
        ]);
    }
}
