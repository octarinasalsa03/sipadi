<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        // var_dump($_SESSION['role']);
        if( $this->session->userdata('role') != 3) {
            if($this->session->userdata('role') == 1){
                redirect('mahasiswa');
            } elseif($this->session->userdata('role') == 2) {
                redirect('dosen/kelas');
            }
        }
        // check_mahasiswa();
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        // check_mahasiswa();
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('kelas_model');
        $data['kelas'] = $this->kelas_model->get_kelas()->result();
        // var_dump($data['kelas']);

        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_kelas()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['dosens'] = $this->db->get_where('users', ['role' => 2])->result();

        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('kodeseksi', 'Kode Seksi', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('dosen', 'Dosen', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('admin/tambah_kelas', $data);
            $this->load->view('templates/footer');
        } else {
            $dosen = $this->db->get_where('dosen', ['user_id' => $this->input->post('dosen')])->row_array();
            $dosen_id = $dosen['id'];
            $datas = [
                'kode' => $this->input->post('kodeseksi'),
                'hari' => $this->input->post('hari'),
                'waktu' => $this->input->post('waktu'),
                'semester' => $this->input->post('semester'),
                'matakuliah_id' => 1,
                'dosen_id' => $dosen_id
            ];
            // $this->form_validation->set_data($datas);
            // // var_dump($datas);
            
            $this->load->model('admin_model');
            $this->admin_model->tambah_kelas($datas);

            // $this->db->insert('kelas', $datas);
            $this->session->set_flashdata('success', 'Kelas telah ditambahkan!');
            redirect('admin/index');
        }
        // $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }
    
    public function profil()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
        // var_dump($data['user_mhs']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/profil', $data);
        $this->load->view('templates/footer');
    }
}
