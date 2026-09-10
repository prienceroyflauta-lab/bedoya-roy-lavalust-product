<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->call->library('session');
        $this->session = $this->call->library('session');
        $this->call->database();
        $this->call->model('UserModel');
        $this->UserModel->ensure_default_admin();
    }

    public function loginForm()
    {
        $data = [
            'error' => $this->session->flashdata('error') ?: '',
            'success' => $this->session->flashdata('success') ?: '',
        ];

        $this->call->view('auth/login', $data);
    }

    public function login()
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $this->session->set_flashdata('error', 'Please enter both a username and a password.');
            redirect('/login');
        }

        $user = $this->UserModel->authenticate($username, $password);

        if ($user) {
            $user_id = is_array($user) ? ($user['id'] ?? null) : ($user->id ?? null);
            $username_value = is_array($user) ? ($user['username'] ?? '') : ($user->username ?? '');
            $role_value = is_array($user) ? ($user['role'] ?? 'user') : ($user->role ?? 'user');

            $this->session->set_userdata([
                'logged_in' => true,
                'user_id' => $user_id,
                'username' => $username_value,
                'role' => $role_value,
            ]);
            $this->session->set_flashdata('success', 'Welcome back, little helper!');
            redirect('/products');
        }

        $this->session->set_flashdata('error', 'The rhyme book says those credentials do not match.');
        redirect('/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/login');
    }
}
