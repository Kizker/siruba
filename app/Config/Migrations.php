<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSirubaTables extends Migration
{
    public function up()
    {
        // Table: administrator
        $this->forge->addField([
            'id_admin' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_admin' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'foto_profil' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default-admin.png'],
            'level' => ['type' => 'ENUM', 'constraint' => ['superadmin', 'admin'], 'default' => 'admin'],
            'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP', 'on update' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id_admin', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('administrator');

        // Table: anggota
        $this->forge->addField([
            'id_anggota' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'npm' => ['type' => 'VARCHAR', 'constraint' => 20],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'nomor_telepon' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'alamat' => ['type' => 'TEXT', 'null' => true],
            'foto_profil' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default.png'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Aktif', 'Tidak Aktif'], 'default' => 'Aktif'],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP', 'on update' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id_anggota', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addUniqueKey('npm');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('anggota');

        // Table: buku
        $this->forge->addField([
            'id_buku' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul_buku' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'penulis' => ['type' => 'VARCHAR', 'constraint' => 150],
            'kategori' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'gambar_sampul' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default.jpg'],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP', 'on update' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id_buku', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('buku');

        // Table: peminjaman
        $this->forge->addField([
            'id_peminjaman' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_anggota' => ['type' => 'INT', 'unsigned' => true],
            'id_buku' => ['type' => 'INT', 'unsigned' => true],
            'tanggal_pinjam' => ['type' => 'DATE'],
            'tanggal_pengembalian' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['Sedang Dipinjam', 'Telah Dikembalikan', 'Terlambat'], 'default' => 'Sedang Dipinjam'],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP', 'on update' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id_peminjaman', true);
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id_anggota', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_buku', 'buku', 'id_buku', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
        $this->forge->dropTable('buku');
        $this->forge->dropTable('anggota');
        $this->forge->dropTable('administrator');
    }
}
