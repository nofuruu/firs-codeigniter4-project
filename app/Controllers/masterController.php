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
        // $keyword = $this->request->getGet('keyword');
        // $orderBy = $this->request->getGet('orderBy') ?? 'userid';
        // $orderDir = $this->request->getGet('orderDir') ?? 'ASC';

        // if ($keyword) {
        //     $subscriptions = $this->MsuserModel->searchWithOrder($keyword, $orderBy, $orderDir);
        // } else {
        //     $subscriptions = $this->MsuserModel->orderBy($orderBy, $orderDir)->findAll();
        // }

        // if ($this->request->isAJAX()) {
        //     return $this->response->setJSON($subscriptions);
        // }

        // $data = [
        //     'subscriptions' => $subscriptions,
        //     'keyword' => $keyword,
        //     'orderBy' => $orderBy,
        //     'orderDir' => $orderDir,
        // ];

        // return view('v_master', $data);
    }

    public function getData()
    {
        $data = $this->MsuserModel->getData();
        return $this->response->setJSON($data);



        // $keyword = $this->request->getGet('keyword');
        // $subscriptions = $this->MsuserModel;

        // if ($keyword) {
        //     $subscriptions = $subscriptions->like('LOWER(usernm)', strtolower($keyword))
        //                                    ->orLike('LOWER(createddate)', strtolower($keyword));
        // }

        // $subscriptions = $subscriptions->orderBy('userid', 'ASC')->findAll();
        // return $this->response->setJSON(['data' => $subscriptions]);
    }

    public function addUser()
    {

            $model = $this->MsuserModel;
            $this->MsuserModel->db->transBegin();

            try{
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');
                $password = md5($password);

                $user = $this->MsuserModel->getOneData($username)->getRowArray();
                if($user){
                    $data = [
                        'status' => 'error',
                        'messafe' => 'Username sudah digunakan'
                    ];
                    return $this->response->setJSON($data);
                }

                if($username == '' || $password == ''){
                    $data = [
                        'status' => 'error',
                        'message' => 'Username sudah digunakan'
                    ];
                    return $this->response->setJSON($data);
                }
                $data = [
                    'usernm' => $username,
                    'password' => $password,
                    'createddate' => date('Y-m-d H:i:s'),
                    'createdby' => session()->get('userid'),
                    'updateddate' => date('Y-m-d H:i:s'),
                    'update' => session()->get('userid'),
                ];
                $this->MsuserModel->saveUser( $data );

                if($this->db->transStatus() == FALSE){
                    $model->db->transRollback();
                    $data = [
                        'status' => 'success',
                        'message' => 'Data Gagal Disimpan..'
                    ];
                    return $this->response->setJSON($data);     
            }
            $data = [
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan'
            ];

            $model->db->transCommit();
            return $this->response->setJSON($data);




        // $model = new MsuserModel();
        // $model->db->transBegin();
        // try {
        //     $username = $this->request->getPost('username');
        //     $password = md5($this->request->getPost('password')); // Hash password with MD5

        //     // Check if username and password combination already exists
        //     if ($this->MsuserModel->where('usernm', $username)->where('password', $password)->first()) {
        //         $model->db->transRollback();
        //         return $this->response->setJSON(['status' => 'error', 'message' => 'Username and password combination already exists.']);
        //     }

        //     if ($username == '' || $password == '') {
        //         $model->db->transRollback();
        //         return $this->response->setJSON(['status' => 'error', 'message' => 'Data Tidak boleh kosong']);
        //     }

        //     // Insert new user
        //     $this->MsuserModel->insert([
        //         'usernm' => $username,
        //         'password' => $password,
        //         'createddate' => date('Y-m-d H:i:s'),
        //         'createdby' => 1, // You can set this to the current user's ID if available
        //     ]);

        //     $model->db->transComplete();

        //     if ($model->db->transStatus() === FALSE) {
        //         $model->db->transRollback();
        //         return $this->response->setJSON(['status' => 'error', 'message' => 'Transaction failed.']);
        //     }

        //     $model->db->transCommit();

        //     $newUser = $this->MsuserModel->where('usernm', $username)->where('password', $password)->first();

        //     return $this->response->setJSON(['status' => 'success', 'data' => $newUser]);
        // } catch (\Exception $e) {
        //     $model->db->transRollback();
        //     return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        // }
        }catch(\Exception $e){
            $model->db->transRollback();
            $data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $this->response->setJSON($data);
        }
    }
    

    public function updateUser()
    {
        $model = new MsuserModel();
        $model->db->transBegin();

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

            $user = $model->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
            }

            $updateData = [
                'usernm' => $username,
                'password' => md5($password) // Gunakan MD5 untuk hashing password
            ];

            $model->update($id, $updateData);

            // Commit transaksi
            $model->db->transCommit();

            // Ambil data yang diperbarui
            $updatedUser = $model->find($id);

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $updatedUser
            ]);
        } catch (\Exception $e) {
            $model->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteUser()
    {
        $id = $this->request->getPost('id');
        $this->MsuserModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
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