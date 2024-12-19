<?php

namespace App\Models;

use CodeIgniter\Model;

class pendaftaranModel extends Model
{
    protected $table      = 'pendaftaran'; // Nama tabel
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 
        'password', 
        'nama_lengkap', 
        'paket_select', 
        'paket_detail', 
        'status', 
        'created_at'
    ];

    protected $useTimestamps = true;

    public function searchWithOrder($keyword, $orderBy = 'id', $orderDir = 'ASC')
    {
        $query = $this->like('username', $keyword)
                      ->orLike('nama_lengkap', $keyword)
                      ->orLike('status', $keyword)
                      ->orLike('paket_select', $keyword)
                      ->orderBy($orderBy, $orderDir);
                      
        return $query->findAll();
    }
}
