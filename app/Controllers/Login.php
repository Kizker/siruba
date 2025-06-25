<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\AdminModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    protected $anggotaModel;
    protected $adminModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->adminModel   = new AdminModel();
    }

    // Halaman login utama
    public function index(): string
    {
        // echo password_hash('admin2025', PASSWORD_DEFAULT);

        return view('logins/login');
    }

    // Halaman login alternatif (jika dibutuhkan)
    public function masuk(): string
    {
        return view('logins/masuk');
    }

    // Halaman pendaftaran akun
    public function daftar(): string
    {
        return view('logins/daftar');
    }

    // ✅ Proses Login
    public function cek()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password wajib diisi.');
        }

        // 🔍 Cek ke tabel administrator dulu
        $admin = $this->adminModel
            ->where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if ($admin && password_verify($password, $admin['password'])) {
            // Set session admin
            session()->set([
                'admin_id'    => $admin['id_admin'],
                'admin_nama'  => $admin['nama_admin'],
                'admin_email' => $admin['email'],
                'admin_level' => $admin['level'],
                'admin_foto'  => $admin['foto_profil'] ?? 'admin-avatar.png',
                'isAdmin'     => true,
                'isLoggedIn'  => true,
            ]);

            return redirect()->to('/dashboard'); // ⬅️ Redirect ke halaman admin
        }

        // 🔍 Jika bukan admin, cek anggota
        $user = $this->anggotaModel
            ->where('email', $username)
            ->orWhere('npm', $username)
            ->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email atau NPM tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        if (strtolower($user['status']) !== 'aktif') {
            return redirect()->back()->with('error', 'Akun Anda belum aktif. Silakan hubungi admin.');
        }

        // Set session anggota
        session()->set([
            'user_id'    => $user['id_anggota'],
            'user_nama'  => $user['nama_lengkap'],
            'user_email' => $user['email'],
            'user_foto'  => $user['foto_profil'] ?? 'default-avatar.png',
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/'); // ⬅️ Redirect ke halaman home
    }


    // ✅ Proses Pendaftaran Anggota
    public function prosesDaftar()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama Lengkap harus diisi.',
                    'min_length' => 'Nama Lengkap minimal 3 karakter.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[anggota.email]',
                'errors' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Format Email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan.'
                ]
            ],
            'npm' => [
                'rules'  => 'required|numeric|is_unique[anggota.npm]',
                'errors' => [
                    'required'  => 'NPM harus diisi.',
                    'numeric'   => 'NPM harus berupa angka.',
                    'is_unique' => 'NPM sudah digunakan.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'confirm_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok.'
                ]
            ],
            'nomor_telepon' => [
                'rules'  => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'Nomor telepon harus berupa angka.'
                ]
            ],
            'alamat' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Alamat terlalu panjang.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $slug = url_title($this->request->getPost('nama_lengkap'), '-', true);

        $this->anggotaModel->insert([
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'email'          => $this->request->getPost('email'),
            'npm'            => $this->request->getPost('npm'),
            'slug'           => $slug,
            'password'       => $hashedPassword,
            'nomor_telepon'  => $this->request->getPost('nomor_telepon'),
            'alamat'         => $this->request->getPost('alamat'),
            'status'         => 'Aktif',
            'foto_profil'    => 'default-avatar.png'
        ]);

        return redirect()->to('/masuk')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // ✅ Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
