<?php

namespace App\Models;

use CodeIgniter\Model;

class MsuserModel extends Model
{
    protected $table = 'msuser';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['usernm', 'password', 'createddate', 'createdby', 'updateddate', 'updatedby'];

    protected $useTimestamps = true;
    protected $createdField  = 'createddate';
    protected $updatedField  = 'updateddate';

    public function searchWithOrder($keyword, $orderBy = 'userid', $orderDir = 'ASC')
    {
        $query = $this->like('usernm', $keyword)
                      ->orLike('password', $keyword)
                      ->orderBy($orderBy, $orderDir);
                      
        return $query->findAll();
    }

    public function getUser($username, $password){
        return $this->where('usernm', $username)->where
        ('password', $password)->first();
    }

    public function saveUser($data){
        return $this->insert($data);
    }

    public function updateUser($data,){
        return $this->update($data, );

    }

    public function getData(){
        return $this->orderBy('updateddate', 'desc')
        ->findAll();
    }

    public function getOneData($param = '', $field = 'usernm'){
        if ($param != '') {
            $this->where($field, $param);
        }
        return $this->get();
    }
}