<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\PeminjamanModel;
use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $bukuModel;
    protected $anggotaModel;
    protected $peminjamanModel;
    protected $adminModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->anggotaModel = new AnggotaModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->adminModel = new AdminModel();
    }

    public function index(): string
    {
        // Cek apakah session id_admin tersedia
        $idAdmin = session()->get('id_admin');
        $admin = $this->adminModel->find($idAdmin);

        // Total data
        $totalBuku = $this->bukuModel->countAll();
        $totalAnggota = $this->anggotaModel->countAll();
        $totalPeminjaman = $this->peminjamanModel->countAll();
        $totalAdmin = $this->adminModel->countAll();

        // Buku terbaru
        $bukuTerbaru = $this->bukuModel
            ->orderBy('id_buku', 'DESC')
            ->findAll(3);

        // Anggota terbaru
        $anggotaTerbaru = $this->anggotaModel
            ->orderBy('id_anggota', 'DESC')
            ->findAll(3);

        // Peminjaman terbaru lengkap dengan nama dan judul buku
        $peminjamanTerbaru = $this->peminjamanModel
            ->select('peminjaman.*, anggota.nama_lengkap, buku.judul_buku')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->limit(3)
            ->find();

        return view('admins/index', [
            'totalBuku' => $totalBuku,
            'totalAnggota' => $totalAnggota,
            'totalPeminjaman' => $totalPeminjaman,
            'bukuTerbaru' => $bukuTerbaru,
            'anggotaTerbaru' => $anggotaTerbaru,
            'transaksiTerbaru' => $peminjamanTerbaru,
            'admin' => $admin
        ]);
    }
}
