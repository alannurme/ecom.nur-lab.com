<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\SettingModel;

class User extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function login()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12)
        ];

        return view('frontend/user/login', $data);
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->db->table('users')->where('email', $email)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set('user', $user);
            return redirect()->to(base_url('user/dashboard'));
        }

        return redirect()->back()->with('error', 'Invalid email or password credentials.');
    }

    public function register()
    {
        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12)
        ];

        return view('frontend/user/register', $data);
    }

    public function registerProcess()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $exists = $this->db->table('users')->where('email', $email)->get()->getRowArray();
        if ($exists) {
            return redirect()->back()->with('error', 'Email is already registered.');
        }

        $userData = [
            'user_type' => 'customer',
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($userData);
        $userId = $this->db->insertID();
        $userData['id'] = $userId;

        $this->session->set('user', $userData);

        return redirect()->to(base_url('user/dashboard'));
    }

    public function dashboard()
    {
        $user = $this->session->get('user');
        if (!$user) {
            return redirect()->to(base_url('user/login'));
        }

        $categoryModel = new CategoryModel();
        $settingModel = new SettingModel();

        $data = [
            'site_name' => $settingModel->getSetting('website_name', 'NUR-LAB ECOM'),
            'categories' => $categoryModel->getMainCategories(12),
            'user' => $user
        ];

        return view('frontend/user/dashboard', $data);
    }

    public function logout()
    {
        $this->session->remove('user');
        return redirect()->to(base_url());
    }
}
