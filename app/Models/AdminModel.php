<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'administrator';
    protected $primaryKey       = 'id_admin';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nama_admin',
        'email',
        'username',
        'password',
        'foto_profil',
        'level',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callback untuk auto-hash password sebelum insert/update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        // Cegah double hash
        if (password_get_info($data['data']['password'])['algo'] === 0) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    // Ambil data admin berdasarkan username atau email
    public function getByLogin(string $login)
    {
        return $this->where('username', $login)
            ->orWhere('email', $login)
            ->first();
    }
}
