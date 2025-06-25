<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\AnggotaModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $bukuModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index(): string
    {
        // Ambil data peminjaman terbaru + relasi anggota & buku, gunakan pagination
        $peminjaman = $this->peminjamanModel
            ->select('peminjaman.*, anggota.nama_lengkap, buku.judul_buku')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->paginate(5, 'peminjaman'); // ganti angka 5 jika ingin jumlah berbeda

        $data = [
            'peminjaman' => $peminjaman,
            'pager' => $this->peminjamanModel->pager,
            'anggota' => $this->anggotaModel->findAll(),
            'buku' => $this->bukuModel->findAll(),
            'errors' => session('errors') ?? [],
            'modal' => session('modal') ?? null,
            'edit_data' => session('edit_data') ?? [],
        ];

        return view('admins/peminjaman', $data);
    }

    public function delete($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function update()
    {
        $id = $this->request->getPost('id_peminjaman');
        if (!$id) {
            return redirect()->to('/peminjaman')->with('error', 'ID peminjaman tidak valid.');
        }

        $peminjamanLama = $this->peminjamanModel->find($id);
        if (!$peminjamanLama) {
            return redirect()->to('/peminjaman')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Validasi input form
        $rules = [
            'id_anggota' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Nama peminjam wajib dipilih',
                    'integer' => 'Format ID peminjam tidak valid'
                ]
            ],
            'id_buku' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Judul buku wajib dipilih',
                    'integer' => 'Format ID buku tidak valid'
                ]
            ],
            'tanggal_pinjam' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal pinjam wajib diisi',
                    'valid_date' => 'Format tanggal pinjam tidak valid'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status wajib dipilih'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal', 'edit')
                ->with('edit_data', $this->request->getPost());
        }

        // Data baru dari form
        $dataBaru = [
            'id_anggota'           => $this->request->getPost('id_anggota'),
            'id_buku'              => $this->request->getPost('id_buku'),
            'tanggal_pinjam'       => $this->request->getPost('tanggal_pinjam'),
            'tanggal_pengembalian' => $this->request->getPost('tanggal_pengembalian') ?: null,
            'status'               => $this->request->getPost('status'),
        ];

        // Siapkan data lama untuk dibanding
        $dataLamaBanding = $peminjamanLama;
        unset($dataLamaBanding['id_peminjaman'], $dataLamaBanding['created_at'], $dataLamaBanding['updated_at']);
        $dataLamaBanding['tanggal_pengembalian'] ??= null;

        if (array_diff_assoc($dataBaru, $dataLamaBanding) === []) {
            return redirect()->to('/peminjaman')->with('error', 'Tidak ada perubahan data.');
        }

        // Lakukan update
        $updated = $this->peminjamanModel->update($id, $dataBaru);

        if (!$updated) {
            return redirect()->to('/peminjaman')->with('error', 'Gagal menyimpan perubahan.');
        }

        return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function peminjaman_terbaru()
    {
        $peminjamanBaru = $this->peminjamanModel->orderBy('created_at', 'DESC')->findAll(5);

        return view('peminjaman/terbaru', [
            'peminjamanTerbaru' => $peminjamanBaru
        ]);
    }
}
