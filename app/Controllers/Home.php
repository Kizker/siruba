<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\PeminjamanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    protected $bukuModel;
    protected $anggotaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->anggotaModel = new AnggotaModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    private function cekLogin(): ?ResponseInterface
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return null;
    }

    public function index(): ResponseInterface|string
    {
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        $this->updateStatusTerlambat(); // Perbarui status peminjaman

        $buku = $this->bukuModel->orderBy('created_at', 'DESC')->findAll(5);

        $idAnggota = session('user_id');
        $peminjamanAktif = [];

        $dataPeminjaman = $this->peminjamanModel
            ->where('id_anggota', $idAnggota)
            ->whereIn('status', ['Sedang Dipinjam', 'Terlambat']) // hanya yang aktif
            ->findAll();

        foreach ($dataPeminjaman as $p) {
            $peminjamanAktif[$p['id_buku']] = $p; // id_buku => data peminjaman
        }

        return view('home', [
            'buku' => $buku,
            'peminjamanAktif' => $peminjamanAktif,
        ]);
    }

    public function buku(): ResponseInterface|string
    {
        // Cek login
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        // Ambil data buku terbaru dengan pagination
        $buku = $this->bukuModel->orderBy('created_at', 'DESC')->paginate(10, 'buku');
        $pager = $this->bukuModel->pager;

        $idAnggota = session('user_id');

        // Ambil data peminjaman aktif milik user ini
        $peminjamanAktif = [];
        $dataPeminjamanUser = $this->peminjamanModel
            ->where('id_anggota', $idAnggota)
            ->whereIn('status', ['Sedang Dipinjam', 'Terlambat'])
            ->findAll();

        foreach ($dataPeminjamanUser as $p) {
            $peminjamanAktif[$p['id_buku']] = $p;
        }

        // Ambil data peminjaman aktif dari semua anggota (untuk nonaktifkan tombol pinjam)
        $bukuSedangDipinjam = [];
        $dataPeminjamanSemua = $this->peminjamanModel
            ->whereIn('status', ['Sedang Dipinjam', 'Terlambat'])
            ->findAll();

        foreach ($dataPeminjamanSemua as $p) {
            $bukuSedangDipinjam[$p['id_buku']] = true;
        }

        return view('buku', [
            'buku' => $buku,
            'pager' => $pager,
            'peminjamanAktif' => $peminjamanAktif,
            'bukuSedangDipinjam' => $bukuSedangDipinjam, // dikirim ke view
        ]);
    }

    public function profil(): ResponseInterface|string
    {
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        $idAnggota = session('user_id');

        $user = $this->anggotaModel->find($idAnggota);

        $riwayat = $this->peminjamanModel
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->where('id_anggota', $idAnggota)
            ->orderBy('id_peminjaman', 'DESC')
            ->paginate(10, 'riwayat'); // gunakan nama group 'riwayat'

        return view('profil', [
            'user' => $user,
            'riwayat' => $riwayat,
            'pager' => $this->peminjamanModel->pager // kirim pager ke view
        ]);
    }


    public function pinjamBuku()
    {
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        $idBuku = $this->request->getPost('id_buku');
        $userId = session('user_id');
        $fromPage = $this->request->getPost('from') ?? '/';

        // 1. Cek apakah buku ini sedang dipinjam oleh siapa pun
        $bukuSedangDipinjam = $this->peminjamanModel
            ->where('id_buku', $idBuku)
            ->whereIn('status', ['Sedang Dipinjam', 'Terlambat'])
            ->first();

        if ($bukuSedangDipinjam) {
            return redirect()->to($fromPage)->with('error', 'Buku ini sedang dipinjam oleh anggota lain.');
        }

        // 2. Cek apakah user sendiri sedang pinjam buku ini
        $cekPinjam = $this->peminjamanModel
            ->where('id_buku', $idBuku)
            ->where('id_anggota', $userId)
            ->whereIn('status', ['Sedang Dipinjam', 'Terlambat'])
            ->first();

        if ($cekPinjam) {
            return redirect()->to($fromPage)->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        // 3. Proses simpan peminjaman
        $this->peminjamanModel->save([
            'id_anggota' => $userId,
            'id_buku' => $idBuku,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_pengembalian' => $this->request->getPost('tanggal_pengembalian'),
            'status' => 'Sedang Dipinjam'
        ]);

        return redirect()->to($fromPage)->with('success', 'Buku berhasil dipinjam!');
    }

    public function kembalikanBuku()
    {
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        $idPeminjaman = $this->request->getPost('id_peminjaman');
        $fromPage = $this->request->getPost('from') ?? '/';

        if (!$idPeminjaman) {
            return redirect()->to($fromPage)->with('error', 'ID peminjaman tidak ditemukan.');
        }

        $data = $this->peminjamanModel->find($idPeminjaman);
        if (!$data) {
            return redirect()->to($fromPage)->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $this->peminjamanModel->update($idPeminjaman, [
            'status' => 'Telah Dikembalikan'
        ]);

        return redirect()->to($fromPage)->with('success', 'Buku berhasil dikembalikan!');
    }

    private function updateStatusTerlambat()
    {
        $peminjaman = $this->peminjamanModel
            ->where('status', 'Sedang Dipinjam')
            ->findAll();

        $hariIni = date('Y-m-d');

        foreach ($peminjaman as $p) {
            if (!empty($p['tanggal_pengembalian']) && $hariIni > $p['tanggal_pengembalian']) {
                $this->peminjamanModel->update($p['id_peminjaman'], [
                    'status' => 'Terlambat'
                ]);
            }
        }
    }

    public function updateFotoProfil()
    {
        $cek = $this->cekLogin();
        if ($cek instanceof ResponseInterface) return $cek;

        $userId = session('user_id');
        $file = $this->request->getFile('foto_profil');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'assets/img/profile/', $newName); // simpan file

            // Update di database
            $anggotaModel = new AnggotaModel();
            $anggotaModel->update($userId, [
                'foto_profil' => $newName
            ]);

            return redirect()->to('/profil')->with('success', 'Foto berhasil diperbarui!');
        }

        return redirect()->to('/profil')->with('error', 'Gagal memperbarui foto.');
    }
}
