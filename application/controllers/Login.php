<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        // check_already_login();
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('logins');
            $this->load->view('templates/footer');
        } else {
            //validasinya sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('user_model');
        $user = $this->user_model->login($email, $password);

        // $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {
            //cek password
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                $this->session->set_userdata($data);
                if ($user['role'] == 1) {
                    $this->session->set_flashdata('success', 'Berhasil!');
                    redirect('mahasiswa');
                } elseif ($user['role'] == 2) {
                    $this->session->set_flashdata('success', 'Berhasil!');
                    redirect('dosen/kelas');
                } else {
                    $this->session->set_flashdata('success', 'Berhasil!');
                    redirect('admin');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Password!</div>');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered</div>');
            redirect('login');
        }
    }

    public function logout()
    {

        $params = array('id', 'email', 'role');
        $this->session->unset_userdata($params);
        // $this->session->unset_userdata('role');

        $this->session->set_flashdata('message', '<div class="alert-alert-success" role="alert">You have been logged out!</div>');
        redirect('login');
    }
}
