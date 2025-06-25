<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id_peminjaman';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_anggota',
        'id_buku',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aturan Validasi
    protected $validationRules      = [
        'id_anggota'        => 'required|integer|is_not_unique[anggota.id_anggota]',
        'id_buku'           => 'required|integer|is_not_unique[buku.id_buku]',
        'tanggal_pinjam'    => 'required|valid_date',
        'tanggal_pengembalian' => 'permit_empty|valid_date',
        'status'            => 'required|in_list[Sedang Dipinjam,Telah Dikembalikan,Terlambat]',
    ];

    protected $validationMessages   = [
        'id_anggota' => [
            'required'      => 'Anggota peminjam harus dipilih.',
            'is_not_unique' => 'ID Anggota tidak valid atau tidak terdaftar.',
        ],
        'id_buku' => [
            'required'      => 'Buku yang dipinjam harus dipilih.',
            'is_not_unique' => 'ID Buku tidak valid atau tidak terdaftar.',
        ],
        'status' => [
            'in_list' => 'Status peminjaman tidak valid.'
        ]
    ];

    /**
     * Fungsi kustom untuk mengambil data peminjaman dengan JOIN ke tabel anggota dan buku.
     * Ini agar kita bisa mendapatkan nama peminjam dan judul buku, bukan hanya ID-nya.
     *
     * @param int|null $id
     * @return array
     */
    public function getPeminjaman($id = null)
    {
        // Gunakan Query Builder
        $builder = $this->db->table($this->table);

        // Lakukan JOIN
        $builder->select('peminjaman.*, anggota.nama_lengkap, anggota.npm, buku.judul_buku');
        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');
        $builder->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $builder->orderBy('peminjaman.created_at', 'DESC'); // Urutkan berdasarkan data terbaru

        // Jika ada ID spesifik, cari satu data
        if ($id !== null) {
            $builder->where('peminjaman.id_peminjaman', $id);
            return $builder->get()->getRowArray(); // Kembalikan satu baris data
        }

        // Jika tidak ada ID, kembalikan semua data
        return $builder->get()->getResultArray(); // Kembalikan semua hasil
    }
}
