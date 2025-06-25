<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function index(): string
    {
        $buku = $this->bukuModel->orderBy('id_buku', 'DESC')->paginate(5, 'buku'); // gunakan pagination

        $data = [
            'buku' => $buku,
            'pager' => $this->bukuModel->pager, // kirim pager ke view
            'errors' => session('errors') ?? []
        ];

        return view('admins/buku', $data);
    }


    public function create()
    {
        $data = [
            'validation' => session('validation') ?? \Config\Services::validation()
        ];

        return view('admins/buku', $data);
    }

    public function save()
    {
        // Validasi Input
        if (!$this->validate([
            'judul_buku' => [
                'rules' => 'required|min_length[3]|is_unique[buku.judul_buku]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                    'min_length' => '{field} harus memiliki panjang minimal 3 karakter.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'gambar_sampul' => [
                'rules' => 'is_image[gambar_sampul]|mime_in[gambar_sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => '{field} harus berupa gambar',
                    'mime_in' => '{field} harus berformat JPG, JPEG, atau PNG'
                ]
            ]

        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal', 'create');
        }


        // Upload Gambar
        $gambar = $this->request->getFile('gambar_sampul');
        $namaGambar = $gambar->getError() == 4 ? 'default.png' : $gambar->getRandomName();
        if ($gambar->getError() != 4) {
            $gambar->move(ROOTPATH . 'public/assets/img/', $namaGambar);
        }

        $judul = $this->request->getPost('judul_buku');
        $slug = url_title($judul, '-', true);

        // Simpan data buku
        $this->bukuModel->save([
            'judul_buku'    => $judul,
            'slug'          => $slug,
            'penulis'       => $this->request->getPost('penulis'),
            'kategori'      => $this->request->getPost('kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'gambar_sampul' => $namaGambar
        ]);

        session()->setFlashdata('success', 'Buku berhasil ditambahkan');
        return redirect()->to('/buku-buku');
    }

    public function update()
    {
        $id = $this->request->getPost('id_buku');
        $bukuLama = $this->bukuModel->find($id);
        $judulBaru = $this->request->getPost('judul_buku');

        // Validasi input
        if (!$this->validate([
            'judul_buku' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Judul buku harus diisi',
                    'min_length' => 'Judul buku minimal 3 karakter'
                ]
            ],
            'penulis' => ['rules' => 'required', 'errors' => ['required' => 'Penulis harus diisi']],
            'kategori' => ['rules' => 'required', 'errors' => ['required' => 'Kategori harus diisi']],
            'deskripsi' => ['rules' => 'required', 'errors' => ['required' => 'Deskripsi harus diisi']],
            'gambar_sampul' => [
                'rules' => 'permit_empty|is_image[gambar_sampul]|mime_in[gambar_sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'Gambar harus berupa file gambar',
                    'mime_in' => 'Format harus JPG/JPEG/PNG'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('modal', 'edit');
        }

        // Tentukan slug
        $slug = ($judulBaru !== $bukuLama['judul_buku']) ? url_title($judulBaru, '-', true) : $bukuLama['slug'];

        // Proses gambar
        $gambar = $this->request->getFile('gambar_sampul');
        $gambarBaru = $bukuLama['gambar_sampul']; // default pakai gambar lama

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika bukan default
            if ($bukuLama['gambar_sampul'] !== 'default.png' && file_exists(ROOTPATH . 'public/assets/img/' . $bukuLama['gambar_sampul'])) {
                unlink(ROOTPATH . 'public/assets/img/' . $bukuLama['gambar_sampul']);
            }
            $gambarBaru = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/assets/img/', $gambarBaru);
        }

        // Data baru
        $dataBaru = [
            'id_buku'       => $id,
            'judul_buku'    => $judulBaru,
            'slug'          => $slug,
            'penulis'       => $this->request->getPost('penulis'),
            'kategori'      => $this->request->getPost('kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'gambar_sampul' => $gambarBaru
        ];

        // Cek apakah ada perubahan data
        $dataLamaBanding = $bukuLama;
        unset($dataLamaBanding['created_at'], $dataLamaBanding['updated_at']);

        if (array_diff_assoc($dataBaru, $dataLamaBanding) === []) {
            session()->setFlashdata('error', 'Tidak ada perubahan data.');
            return redirect()->to('/buku-buku');
        }

        // Simpan
        $this->bukuModel->save($dataBaru);
        session()->setFlashdata('success', 'Data buku berhasil diperbarui.');
        return redirect()->to('/buku-buku');
    }

    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);

        if (!$buku) {
            session()->setFlashdata('error', 'Buku tidak ditemukan.');
            return redirect()->to('/buku-buku');
        }

        // Hapus gambar jika bukan default
        if (!empty($buku['gambar_sampul']) && $buku['gambar_sampul'] !== 'default.png') {
            $path = FCPATH . 'assets/img/' . $buku['gambar_sampul'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->bukuModel->delete($id);
        session()->setFlashdata('success', 'Buku berhasil dihapus.');
        return redirect()->to('/buku-buku');
    }

    public function buku_terbaru()
    {
        $bukuTerbaru = $this->bukuModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5); // Ambil 5 buku terbaru

        return view('buku/terbaru', [
            'bukuTerbaru' => $bukuTerbaru
        ]);
    }
}
