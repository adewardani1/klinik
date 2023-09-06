<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Auth extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        return view('/login');
    }

    public function proses_login()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'error' => [
                    'required' => 'Username tidak boleh kosong !'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'error' => [
                    'required' => 'Password tidak boleh kosong !'
                ]
            ],
        ])) {
            return redirect()->to('/')->withInput();
        }

        // Ambil data username dan password
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek apakah user ada didatabase
        $adminModel = new AdminModel();
        $user = $adminModel->where('username', $username)->first();

        if ($user && $password === $user['password']) {
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'hak_akses' => $user['hak_akses'],
                'logged_in' => true
            ]);
            return redirect()->to('dashboard');
        } else {
            session()->setFlashdata('error', 'Login Gagal!');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        session()->remove('id_user');
        session()->remove('username');
        session()->remove('hak_akses');
        session()->remove('logged_in');
        session()->setFlashdata('pesan', 'Logout Sukses!');
        return redirect()->to('auth');
    }
}
