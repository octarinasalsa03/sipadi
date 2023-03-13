<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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
            if($user['user_status'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role'] == 1) {
                        $this->session->set_flashdata('success', 'Berhasil login!');
                        redirect('mahasiswa');
                    } elseif ($user['role'] == 2) {
                        $this->session->set_flashdata('success', 'Berhasil login!');
                        redirect('dosen/kelas');
                    } else {
                        $this->session->set_flashdata('success', 'Berhasil login!');
                        redirect('admin');
                    }
                } else {
                    $this->session->set_flashdata('failed', 'Password salah!');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('failed', 'Akun belum diaktivasi!');
                    redirect('auth');

            }
        } else {
            $this->session->set_flashdata('failed', 'Email belum terdaftar!');
            redirect('auth');
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nim', 'Nim', 'required|trim');
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
                'role' => 1,
                'user_status' => 0
            ];

            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->_kirimEmail($token);

            $this->db->insert('users', $data);
            $users_id = $this->db->insert_id();
            $this->db->insert('user_token', $user_token);

            $mhs = [
                'user_id' => $users_id,
                'nim' => $this->input->post('nim')
            ];
            $this->db->insert('mahasiswa', $mhs);

            $this->session->set_flashdata('success', 'Daftar berhasil! Silakan cek email untuk aktivasi akun');
            redirect('auth');
        }
    }

    public function register_dosen()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
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
                'role' => 2,
                'user_status' => 0
            ];

            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->_kirimEmail($token);

            $this->db->insert('users', $data);
            $users_id = $this->db->insert_id();
            $this->db->insert('user_token', $user_token);

            $dosen = [
                'user_id' => $users_id,
            ];
            $this->db->insert('dosen', $dosen);
            $this->session->set_flashdata('success', 'Daftar berhasil! Silakan cek email untuk aktivasi akun');
            redirect('auth');
        }
    }

    public function register_admin()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);


        if ($this->form_validation->run() == false) {
            $data['title'] = 'SIPADI';
            $this->load->view('templates/header', $data);
            $this->load->view('register_admin', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'email' => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama' => $this->input->post('name', true),
                'role' => 3,
                'user_status' => 1
            ];

            $this->db->insert('users', $data);

            $this->session->set_flashdata('success', 'Daftar berhasil! Silakan login');
            redirect('auth');
        }       

    }

    private function _kirimEmail($token)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'sipadi.unj@gmail.com',
            'smtp_pass' => 'awrnusaipyqpwsje', 
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
            ];

            

        $this->email->initialize($config);
        $this->email->from('Sipadi UNJ', 'Verifikasi Email');
		$this->email->to($this->input->post('email'));
        $this->email->message('Klik link ini untuk aktivasi akun Anda : <a href="' . base_url() . 'auth/verifikasi?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>');

		
		$this->email->subject('Verifikasi Email');

        if ($this->email->send()) {
            return true;
        } else {
            $this->session->set_flashdata('failed', 'Pendaftaran gagal!');
            redirect('auth');
        // echo $this->email->print_debugger();
        // die;
        }
    }

    public function verifikasi()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if($user_token) {
                $this->db->set('user_status', 1);
                $this->db->where('email', $email);
                $this->db->update('users');

                $this->db->delete('user_token', ['email' => $email]);
                $this->session->set_flashdata('success', 'Berhasil aktivasi! Silakan login.');
                redirect('auth');
            } else {
                $this->session->set_flashdata('failed', '');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('failed', '');
            redirect('auth');
        }
    }

    public function logout()
    {

        $params = array('id', 'email', 'role');
        $this->session->unset_userdata($params);
        // $this->session->unset_userdata('role');

        $this->session->set_flashdata('message', '<div class="alert-alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }
}