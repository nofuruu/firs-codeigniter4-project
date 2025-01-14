<?php

namespace App\Controllers;

use App\Models\MsuserModel;

class MasterController extends BaseController
{
    protected $MsuserModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->MsuserModel = new MsuserModel();
    }

    public function index()
    {
        $data = [
            'tittle' => 'User'
        ];
        return view('v_master', $data);
    }

    public function getData()
    {
        return $this->response->setJSON($this->MsuserModel->getData());
    }

    public function addUser()
    {
        $this->db->transBegin();

        try {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            // Validasi input
            if (empty($username) || empty($password)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Username atau password tidak boleh kosong'
                ]);
            }

            // Check if username already exists
            $user = $this->MsuserModel->getOneData($username, 'usernm');
            if ($user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Username sudah digunakan'
                ]);
            }

            $password = md5($password);

            $data = [
                'usernm' => $username,
                'password' => $password,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => session()->get('userid'),
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('userid'),
            ];
            $this->MsuserModel->saveUser($data);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Gagal Disimpan'
                ]);
            }

            $this->db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan'
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateUser()
    {
        $this->db->transBegin();

        try {
            $id = $this->request->getPost('id');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if (empty($password)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password is required to update user data.'
                ]);
            }

            $user = $this->MsuserModel->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
            }

            // Check if the same username already exists
            $existingUser = $this->MsuserModel->getOneData($username, 'usernm', $id);
            if ($existingUser) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Username sudah digunakan oleh pengguna lain.'
                ]);
            }

            $updateData = [
                'usernm' => $username,
                'password' => md5($password), // Use MD5 to hash the password
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('userid')
            ];

            $this->MsuserModel->updateUser($id, $updateData);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Gagal Disimpan..'
                ]);
            }

            // Commit the transaction
            $this->db->transCommit();

            // Get the updated user data
            $updatedUser = $this->MsuserModel->find($id);

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $updatedUser
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteUser()
    {
        $this->db->transBegin();

        try {
            $id = $this->request->getPost('id');

            $user = $this->MsuserModel->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
            }

            $this->MsuserModel->deleteUser($id);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Gagal Dihapus..'
                ]);
            }

            // Commit the transaction
            $this->db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getUser()
    {
        $id = $this->request->getGet('id');
        $user = $this->MsuserModel->find($id);

        if ($user) {
            return $this->response->setJSON(['status' => 'success', 'data' => $user]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found.']);
        }
    }
}