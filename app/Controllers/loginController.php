<?php

namespace App\Controllers;

use App\Models\MsuserModel;

class LoginController extends BaseController 
{
    public function index()
    {
        return view("v_login");
    }

    public function login()
    {
        $session = session();
        $model = new MsuserModel();
    
        $username = $this->request->getPost('usernm');
        $password = md5($this->request->getPost('password'));
        
        $users = $model->where('usernm', $username)->findAll();
    
        if ($users) {
            foreach ($users as $user) {
                if ($password === $user['password']) {
                    $session->set([
                        'usernm' => $user['usernm'],
                        'logged_in' => true,
                    ]);
                    return $this->response->setJSON(['status' => 'success', 'redirect' => 'userController']);
                }
            }
            return $this->response->setJSON(['status' => 'error', 'message' => 'Password salah.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username tidak ditemukan.']);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}