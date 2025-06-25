<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index(): string
    {
        $anggota = $this->anggotaModel
            ->orderBy('id_anggota', 'DESC') // terbaru duluan
            ->paginate(5, 'anggota');

        $data = [
            'anggota' => $anggota,
            'pager' => $this->anggotaModel->pager,
            'errors' => session('errors') ?? []
        ];

        return view('admins/anggota', $data);
    }

    public function create()
    {
        $data = [
            'validation' => session('validation') ?? \Config\Services::validation()
        ];

        return view('admins/anggota', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama Lengkap harus diisi.',
                    'min_length' => 'Nama Lengkap minimal 3 karakter.'
                ]
            ],
            'npm' => [
                'rules' => 'required|numeric|is_unique[anggota.npm]',
                'errors' => [
                    'required' => 'NPM harus diisi.',
                    'numeric' => 'NPM harus berupa angka.',
                    'is_unique' => 'NPM sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[anggota.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Format Email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'foto_profil' => [
                'rules' => 'permit_empty|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'Foto Profil harus berupa gambar.',
                    'mime_in' => 'Foto Profil harus berformat JPG, JPEG, atau PNG.'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('modal', 'create');
        }

        // Upload foto profil
        $foto = $this->request->getFile('foto_profil');
        $namaFoto = $foto && $foto->isValid() && !$foto->hasMoved()
            ? $foto->getRandomName()
            : 'default-avatar.png';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $foto->move(ROOTPATH . 'public/assets/img/profile/', $namaFoto);
        }

        // Buat slug otomatis dari nama_lengkap
        $slug = url_title($this->request->getPost('nama_lengkap'), '-', true);

        // Simpan data ke DB
        $this->anggotaModel->save([
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'slug'           => $slug,
            'npm'            => $this->request->getPost('npm'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nomor_telepon'  => $this->request->getPost('nomor_telepon'),
            'alamat'         => $this->request->getPost('alamat'),
            'foto_profil'    => $namaFoto,
            'status'         => $this->request->getPost('status') ?? 'Aktif'
        ]);

        session()->setFlashdata('success', 'Anggota berhasil ditambahkan');
        return redirect()->to('/anggota');
    }

    public function update()
    {
        $id = $this->request->getPost('id_anggota');
        $anggotaLama = $this->anggotaModel->find($id);

        if (!$anggotaLama) {
            session()->setFlashdata('error', 'Anggota tidak ditemukan.');
            return redirect()->to('/anggota');
        }

        // Validasi input
        if (!$this->validate([
            'nama_lengkap'  => 'required|min_length[3]',
            'npm'           => 'required',
            'email'         => 'required|valid_email',
            'nomor_telepon' => 'permit_empty',
            'alamat'        => 'permit_empty',
            'status'        => 'required|in_list[Aktif,Tidak Aktif]',
            'foto_profil'   => 'permit_empty|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('modal', 'edit');
        }

        // Ambil data baru
        $dataBaru = [
            'id_anggota'     => $id,
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'npm'            => $this->request->getPost('npm'),
            'email'          => $this->request->getPost('email'),
            'nomor_telepon'  => $this->request->getPost('nomor_telepon'),
            'alamat'         => $this->request->getPost('alamat'),
            'status'         => $this->request->getPost('status'),
        ];

        // Password opsional
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $dataBaru['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Penanganan upload foto
        $foto = $this->request->getFile('foto_profil');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama jika bukan default
            if (
                $anggotaLama['foto_profil'] !== 'default-avatar.png' &&
                file_exists(ROOTPATH . 'public/assets/img/profile/' . $anggotaLama['foto_profil'])
            ) {
                unlink(ROOTPATH . 'public/assets/img/profile/' . $anggotaLama['foto_profil']);
            }

            $namaFotoBaru = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/assets/img/profile/', $namaFotoBaru);
            $dataBaru['foto_profil'] = $namaFotoBaru;
        } else {
            $dataBaru['foto_profil'] = $anggotaLama['foto_profil']; // tetap pakai foto lama
        }

        // Cek apakah ada perubahan data (hilangkan kolom waktu & password)
        $dataLamaBanding = $anggotaLama;
        unset($dataLamaBanding['created_at'], $dataLamaBanding['updated_at'], $dataLamaBanding['password']);

        // Jika password tidak diubah, jangan bandingkan
        if (empty($password)) {
            unset($dataBaru['password']);
        }

        if (array_diff_assoc($dataBaru, $dataLamaBanding) === []) {
            session()->setFlashdata('error', 'Tidak ada perubahan data.');
            return redirect()->to('/anggota');
        }

        // Simpan ke database
        $this->anggotaModel->save($dataBaru);

        session()->setFlashdata('success', 'Data anggota berhasil diperbarui.');
        return redirect()->to('/anggota');
    }


    public function delete($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (!$anggota) {
            session()->setFlashdata('error', 'Anggota tidak ditemukan.');
            return redirect()->to('/anggota');
        }

        if (!empty($anggota['foto_profil']) && $anggota['foto_profil'] !== 'default-avatar.png') {
            $path = FCPATH . 'assets/img/profile/' . $anggota['foto_profil'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->anggotaModel->delete($id);
        session()->setFlashdata('success', 'Anggota berhasil dihapus.');
        return redirect()->to('/anggota');
    }

    public function anggota_terbaru()
    {
        $anggotaBaru = $this->anggotaModel->orderBy('created_at', 'DESC')->findAll(5);

        return view('anggota/terbaru', [
            'anggotaTerbaru' => $anggotaBaru
        ]);
    }
}


    // echo password_hash('Dea180203', PASSWORD_DEFAULT);