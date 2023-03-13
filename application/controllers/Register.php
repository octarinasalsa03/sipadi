<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'SIPADI';
            $this->load->view('templates/header', $data);
            $this->load->view('register', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'email' => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama' => $this->input->post('name', true),
                'role' => 1
            ];
            $this->db->insert('users', $data);
            $users_id = $this->db->insert_id();

            $mhs = [
                'user_id' => $users_id,
            ];
            $this->db->insert('mahasiswa', $mhs);

            $this->session->set_flashdata('success', 'Berhasil!');
            redirect('login');
        }
    }

    public function dosen()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('nidn', 'NIDN', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'SIPADI';
            $this->load->view('templates/header', $data);
            $this->load->view('register_dosen', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'email' => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama' => $this->input->post('name', true),
                'role' => 2
            ];
            $this->db->insert('users', $data);
            $users_id = $this->db->insert_id();

            $dosen = [
                'user_id' => $users_id,
                'nidn' => $nidn
            ];
            $this->db->insert('dosen', $dosen);
            $this->session->set_flashdata('success', 'Berhasil!');
            redirect('login');
        }
    }
}
