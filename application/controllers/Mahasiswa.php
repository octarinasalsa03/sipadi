<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if( $this->session->userdata('role') != 1) {
            if($this->session->userdata('role') == 2){
                redirect('dosen/kelas');
            } elseif($this->session->userdata('role') == 3) {
                redirect('admin');
            }
        }
        // check_already_login();
        // check_mahasiswa();
    }

    public function index()
    {
        // check_not_login();
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        // var_dump($this->session->userdata('role'));
        $user_id = $data['user']['id'];
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['user_id' => $user_id])->row_array();
        $mahasiswa_id = $data['mahasiswa']['id'];

        $data['kelas_mahasiswa'] = null;
        $this->load->model('kelas_model');
        $this->load->model('mahasiswa_model');
        $data['kelas'] = $this->mahasiswa_model->get_kelas($mahasiswa_id)->result();

        $this->form_validation->set_rules('kelas_id', 'Mahasiswa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('mahasiswa/home_new', $data);
            $this->load->view('templates/footer');
        } else {
            $kelas_id = $this->input->post('kelas_id');
            $data['pertemuans'] = $this->mahasiswa_model->get_pertemuan($kelas_id)->result();
            $query_pertemuan = $this->db->query("SELECT id FROM pertemuan WHERE kelas_id = ". $kelas_id);
            $query_hadir = $this->db->query("SELECT mahasiswa_id FROM presensi
                           WHERE kelas_id = ". $kelas_id . " AND mahasiswa_id = " . $mahasiswa_id . " AND kehadiran = 1");
            $query_tidakhadir = $this->db->query("SELECT mahasiswa_id FROM presensi
                           WHERE kelas_id = ". $kelas_id . " AND mahasiswa_id = " . $mahasiswa_id . " AND kehadiran = 0");
            $data['jumlah_pertemuan'] = $query_pertemuan->num_rows();
            $data['jumlah_kehadiran'] = $query_hadir->num_rows();
            $data['jumlah_ketidakhadiran'] = $query_tidakhadir->num_rows();
            // var_dump($jumlah_kehadiran);
            $data['kelas_mahasiswa'] = $this->mahasiswa_model->get_kelas_mahasiswa($mahasiswa_id, $kelas_id)->result();
            // var_dump($data['kelas_mahasiswa']);
            $this->db->select('mahasiswa_id, kelas_id,
            round(avg(case when tipe = "Tugas" or tipe = "Kuis" then nilai else null end), 2) as tugas,
            sum(case when tipe = "UTS" then nilai else null end) as uts,
            sum(case when tipe = "UAS" then nilai else null end) as uas');
            $this->db->from('nilai AS n');
            $this->db->join('mahasiswa AS m', 'm.id = n.mahasiswa_id', 'INNER');
            $this->db->join('tugas AS t', 't.id = n.tugas_id', 'INNER');
            $this->db->join('users AS u', 'u.id = m.user_id', 'left');
            $this->db->where([
                'mahasiswa_id' => $mahasiswa_id,
                'kelas_id' => $kelas_id
            ]);
            $this->db->group_by('mahasiswa_id, kelas_id');
            $query3 = $this->db->get();
            $data['nilai'] = $query3->result();
            // var_dump($data['nilai'][0]);
            // var_dump($data['kelas_mahasiswa']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('mahasiswa/home_new', $data);
            $this->load->view('templates/footer');            
        }
    }

    public function absensi()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/absensi');
        $this->load->view('templates/footer');
    }

    public function profil()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $this->load->model('mahasiswa_model');
        $data['user_mhs'] = $this->mahasiswa_model->get_mahasiswa($user_id)[0];
        // var_dump($data['user_mhs']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/profil', $data);
        $this->load->view('templates/footer');
    }

    public function kelas()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['user_id' => $user_id])->row_array();

        $this->load->model('kelas_model');
        $data['kelas'] = $this->kelas_model->get_kelas()->result();

        $array = array();
        foreach ($data['kelas'] as $kelas) :
            // $array_push = array(

            // )
            $ql = $this->db->get_where('kelas_mahasiswa', ['kelas_id' => $kelas->id, 'mahasiswa_id' => $data['mahasiswa']['id']]);
            array_push($array, array(
                "id" => $kelas->id,
                "nama" => $kelas->nama,
                "sks" => $kelas->sks,
                "kode" => $kelas->kode,
                "hari" => $kelas->hari,
                "waktu" => $kelas->waktu,
                "matakuliah_id" => $kelas->matakuliah_id,
                "dosen_id" => $kelas->dosen_id,
                "nama_dosen" => $kelas->nama_dosen,
                "mahasiswa_id" => $kelas->mahasiswa_id,
                "gabung" => $ql->num_rows() > 0 ? 1 : 0
            ));
        // if (count($ql) > 0) {
        //     array_push($array, array("gabung" => 1));
        // } else {
        //     array_push($array, array("gabung" => 0));
        // }
        endforeach;

        $array_encode = json_encode($array);
        $data['kelas_decode'] = json_decode($array_encode);
        //var_dump($array_decode);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/kelas_mahasiswa', $data);
        $this->load->view('templates/footer');
    }

    public function kelas_detail($id = NULL, $kode_kelas = NULL)
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['user_id' => $user_id])->row_array();

        $mahasiswa_id = $data['mahasiswa']['id'];
        // var_dump($mahasiswa_id);
        $this->load->model('mahasiswa_model');
        $this->load->model('kelas_model');
        // var_dump($data['kelas_mahasiswas']);
        // var_dump($id);
        $data['kelas'] = $this->mahasiswa_model->get_data_kelas($kode_kelas)->result();
        $data['tugas'] = $this->mahasiswa_model->get_data_nilai($mahasiswa_id, $id)->result();
        // var_dump($data['kelas']);
        $kelas_id = $data['kelas'][0]->id;
        
        $data['pertemuans'] = $this->mahasiswa_model->get_pertemuan($id)->result();
        // var_dump($data['pertemuans']);
        $array = array();
        if($data['pertemuans'] != null) {
            foreach ($data['pertemuans'] as $pertemuan) :
                $ql = $this->db->get_where('presensi', ['kelas_id' => $id, 'mahasiswa_id' => $mahasiswa_id, 'pertemuan_id' => $pertemuan->id]);
                array_push($array, array(
                    "id" => $pertemuan->id,
                    "pertemuan" => $pertemuan->pertemuan,
                    "tanggal" => $pertemuan->tanggal,
                    "materi" => $pertemuan->materi,
                    "hadir" => $ql->num_rows() > 0 ? 1 : 0
                ));
            endforeach;
            $array_encode = json_encode($array);
            $data['kehadiran_encode'] = json_decode($array_encode);
        }


        $i = 0;
        $data['kelas_mahasiswas'] = $this->kelas_model->get_kelas_mahasiswa($id)->result();
        $array2 = array();

        if($data['kelas_mahasiswas'] != null) {
            foreach ($data['pertemuans'] as $pertemuan) :
                // $array2 = array()
                // echo($pertemuan->id);
                $array_mahasiswa = array();
                foreach ($data['kelas_mahasiswas'] as $kelas_mahasiswa) :
                    $ql1 = $this->db->get_where('presensi', ['kelas_id' => $id, 'mahasiswa_id' => $mahasiswa_id, 'pertemuan_id' => $pertemuan->id]);
                    $ql2 = $this->db->get_where('presensi', ['kelas_id' => $id, 'mahasiswa_id' => $kelas_mahasiswa->mahasiswa_id, 'pertemuan_id' => $pertemuan->id]);
                    // var_dump($ql2);
                    $isi_array_mahasiswa = array(
                        "mahasiswa_id" => $kelas_mahasiswa->mahasiswa_id,
                        "nama_mahasiswa" => $kelas_mahasiswa->nama,
                        // "kelas_id" => $kelas_mahasiswa->kelas_id,
                        "hadir" => $ql2->num_rows() > 0 ? 1 : 0
                    );
                    $array_mahasiswa[] = ['mahasiswa' => $isi_array_mahasiswa];
                endforeach;
                $array2[$i][] = array(
                    'pertemuan_id' => $pertemuan->id, 
                    "nama_pertemuan" => $pertemuan->pertemuan,
                    "tanggal" => $pertemuan->tanggal,
                    "materi" => $pertemuan->materi,
                    "hadir" => $ql1->num_rows() > 0 ? $ql1->row_array()['kehadiran'] : 2,
                    'presensi_mhs' => $array_mahasiswa);
            endforeach;
            $array_encode2 = json_encode($array2);
            $data['kehadiran_encode2'] = json_decode($array_encode2);
        }
        // var_dump($data['kehadiran_encode2'][0][0]->presensi_mhs[0]->mahasiswa->mahasiswa_id);
        // foreach ($data['kehadiran_encode2'][0] as $kehadirann):
        // foreach ($kehadirann as $kehadiran):
        //     var_dump($kehadiran);
        // endforeach;
        // endforeach;
        // var_dump($data['kehadiran_encode2']);
        
        $this->form_validation->set_rules('mahasiswa_id[]', 'Mahasiswa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('mahasiswa/kelas', $data);
            $this->load->view('templates/footer');
        } else {
            $mahasiswa_id = $this->input->post('mahasiswa_id');
            $kelas_id = $this->input->post('kelas_id');
            $kehadiran_id = $this->input->post('kehadiran_id');
            $kehadiran = $this->input->post('kehadiran');
            // var_dump($kehadiran);
            // for ($i = 0; $i < count($mahasiswa_id); $i++) {
            foreach ($mahasiswa_id as $key=>$value) {
                if($kehadiran[$key] != null) {
                    $data = [
                        [
                            'mahasiswa_id' => $mahasiswa_id[$key],
                            'kelas_id' => $kelas_id[$key],
                            'kehadiran' => $kehadiran[$key],
                            'pertemuan_id' => $kehadiran_id[$key]
                        ]
                    ];
                    // var_dump(count($mahasiswa_id));
                    $this->db->insert_batch('presensi', $data);
                }
            }
            redirect($_SERVER['HTTP_REFERER']); 
        }
    }

    public function gabung_kelas($id = NULL)
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['user_id' => $user_id])->row_array();
        $mahasiswa_id = $data['mahasiswa']['id'];

        $data = [
            'mahasiswa_id' => $mahasiswa_id,
            'kelas_id' => $id,
        ];
        $this->db->insert('kelas_mahasiswa', $data);
        $this->session->set_flashdata('success', 'Berhasil!');
        redirect('/mahasiswa/kelas', 'refresh');
    }

    public function tambah_pertemuan($id = NULL, $kode_kelas = '')
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $data['mahasiswa'] = $this->db->get_where('mahasiswa', ['user_id' => $user_id])->row_array();
        $mahasiswa_id = $data['mahasiswa']['id'];

        $this->load->model('mahasiswa_model');
        $data['kelas'] = $this->mahasiswa_model->get_data_kelas($kode_kelas)->result();
        // var_dump($data['kelas']);
        $data['tugas'] = $this->mahasiswa_model->get_data_nilai($mahasiswa_id, $id)->result();

        $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('materi', 'Materi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('mahasiswa/tambah_pertemuan', $data);
            $this->load->view('templates/footer');
        } else {

            $datas = [
                'pertemuan' => $this->input->post('pertemuan'),
                'tanggal' => $this->input->post('tanggal'),
                'materi' => $this->input->post('materi'),
                'kelas_id' => $id,
            ];
            // $this->form_validation->set_data($datas);
            // // var_dump($datas);
            $this->load->model('pertemuan_model');
            $this->pertemuan_model->tambah_pertemuan($datas);

            // $this->db->insert('pertemuan', $datas);
            redirect('mahasiswa/kelas_detail/' . $kode_kelas . "/" . $id);
        }
    }

    // public function isi_absensi()
    // {
    //     // $arr = array('pertemuan' => $_POST['pertemuan']);
    //     // // print_r($_POST);
    //     $pertemuan  = $this->input->post('pertemuan'); //changes
    //     $mahasiswa_id  = $this->input->post('mahasiswa'); //changes
    //     $kelas_id  = $this->input->post('kelas_id'); //changes
    //     $datas = [
    //         'mahasiswa_id' => $mahasiswa_id,
    //         'kelas_id' => $kelas_id,
    //         'kehadiran' => 1,
    //         'pertemuan_id' => $pertemuan,
    //     ];
    //     // $this->db->insert('presensi', $datas);
    //     $this->load->model('presensi_model');
    //     $this->presensi_model->isi_presensi($datas);
    //     // // $this->load->library("firephp");
    //     // // $this->firephp->log($_POST);
    //     // header('Content-Type: application/json');
    //     // return json_encode($arr);
    // }
}
