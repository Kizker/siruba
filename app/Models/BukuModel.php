<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id_buku';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Tambahkan 'slug' ke dalam allowedFields
    protected $allowedFields    = [
        'judul_buku',
        'slug', // <-- TAMBAHKAN INI
        'penulis',
        'kategori',
        'deskripsi',
        'gambar_sampul'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callbacks untuk membuat slug secara otomatis
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    /**
     * Fungsi callback untuk membuat slug dari judul buku.
     *
     * @param array $data
     * @return array
     */
    protected function generateSlug(array $data)
    {
        // Hanya jalankan jika ada judul buku di data yang dikirim
        if (!isset($data['data']['judul_buku'])) {
            return $data;
        }

        $slug = url_title($data['data']['judul_buku'], '-', true);
        $data['data']['slug'] = $this->getUniqueSlug($slug, $data);

        return $data;
    }

    /**
     * Memastikan slug yang dihasilkan unik di database.
     * Jika sudah ada, tambahkan angka di belakangnya (contoh: judul-buku-2)
     *
     * @param string $slug
     * @param array $data
     * @return string
     */
    private function getUniqueSlug(string $slug, array $data): string
    {
        $originalSlug = $slug;
        $counter = 1;

        // Cek apakah ada primary key (ID) yang dikirim (artinya ini proses update)
        $id = $data['id'][0] ?? null;

        while (true) {
            // Buat query builder untuk mencari slug
            $builder = $this->where('slug', $slug);

            // Jika ini proses update, kecualikan data yang sedang diupdate
            if ($id) {
                $builder->where($this->primaryKey . ' !=', $id);
            }

            // Jika tidak ditemukan slug yang sama, kembalikan slug saat ini
            if ($builder->countAllResults() == 0) {
                return $slug;
            }

            // Jika ditemukan, tambahkan angka dan cek lagi
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    }

    public function getBuku($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
