<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id_anggota';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Tambahkan 'slug' ke dalam allowedFields
    protected $allowedFields    = [
        'nama_lengkap',
        'slug', // <-- TAMBAHKAN INI
        'npm',
        'email',
        'password',
        'nomor_telepon',
        'alamat',
        'foto_profil',
        'status'
    ];

    // Timestamps
    protected $useTimestamps = true;

    // Menggabungkan dua callback: satu untuk hash password, satu untuk slug
    protected $beforeInsert = ['hashPassword', 'generateSlug'];
    protected $beforeUpdate = ['hashPassword', 'generateSlug'];

    /**
     * Fungsi callback untuk hashing password.
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            // Cegah double hash
            if (password_get_info($data['data']['password'])['algo'] === 0) {
                $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            }
        }
        return $data;
    }

    /**
     * Fungsi callback untuk membuat slug dari nama lengkap.
     */
    protected function generateSlug(array $data)
    {
        if (!isset($data['data']['nama_lengkap'])) {
            return $data;
        }

        $slug = url_title($data['data']['nama_lengkap'], '-', true);
        $data['data']['slug'] = $this->getUniqueSlug($slug, $data); // Menggunakan fungsi yang sama

        return $data;
    }

    private function getUniqueSlug(string $slug, array $data): string
    {
        $originalSlug = $slug;
        $counter = 1;
        $id = $data['id'][0] ?? null;

        while ($this->where('slug', $slug)->where($this->primaryKey . ' !=', $id)->countAllResults() > 0) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    public function getAnggota($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
