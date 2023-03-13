<?php
defined('BASEPATH') or exit('No direct script access allowed');
require './vendor/autoload.php';

use Rubix\ML\Classifiers\NaiveBayes;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\CrossValidation\HoldOut;
use Rubix\ML\Classifiers\GaussianNB;
use Rubix\ML\Extractors\CSV;

class Dosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if( $this->session->userdata('role') != 2) {
            if($this->session->userdata('role') == 1){
                redirect('mahasiswa');
            } elseif($this->session->userdata('role') == 3) {
                redirect('admin');
            }
        }
        // check_mahasiswa();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $dosen_id = $data['user']['id'];

        $this->load->model('kelas_model');
        $data['kelas'] = $this->kelas_model->get_data($dosen_id)->result();
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dosen/kelas_dosen', $data);
        $this->load->view('templates/footer');
    }

    public function profil()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $data['user']['id'];
        $this->load->model('dosen_model');
        $data['user_dosen'] = $this->dosen_model->get_dosen($user_id)[0];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dosen/profil', $data);
        $this->load->view('templates/footer');
    }

    public function kelas()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $teacher_id = $data['user']['id'];

        $this->load->model('kelas_model');
        $data['kelas'] = $this->kelas_model->get_data($data['user']['id'])->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dosen/kelas_dosen', $data);
        $this->load->view('templates/footer');
    }

    public function absensi()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('mahasiswa/absensi');
        $this->load->view('templates/footer');
    }

    public function kelas_detail($id = '', $kode_kelas = '')
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->model('kelas_model');
        $this->load->model('tugas_model');
        $this->load->model('dosen_model');
        $data['kelas'] = $this->kelas_model->get_all_data($id)->result_array();
        // var_dump($data['kelas']);
        $data['mahasiswa'] = $this->kelas_model->get_mahasiswakelas($kode_kelas)->result();
        $data['mahasiswa_kelas'] = $this->kelas_model->get_data_mhskelas($id)->result();
        $data['kelas_mahasiswa'] = $this->kelas_model->get_kelas_mahasiswa($id)->result();
        // var_dump($id);
        $data['pertemuans'] = $this->kelas_model->get_pertemuan($id)->result();
        $data['tugas'] = $this->tugas_model->get_data($id);

        $data['nilai_mahasiswas'] = null;

        $query = $this->db->query("select `nilai`.`id` AS `id`,`nilai`.`mahasiswa_id` AS `mahasiswa_id`,`nilai`.`tugas_id` AS `tugas_id`,`users`.`nama` AS `Nama`,`tugas`.`nama_tugas` AS `nama_tugas`,`tugas`.`tipe` AS `tipe`,`tugas`.`bobot` AS `bobot`,`tugas`.`kelas_id` AS `kelas_id`,`nilai`.`nilai` AS `nilai` from (((`tugas` join `nilai` on(`tugas`.`id` = `nilai`.`tugas_id`)) left join `mahasiswa` on(`mahasiswa`.`id` = `nilai`.`mahasiswa_id`)) left join `users` on(`users`.`id` = `mahasiswa`.`user_id`))
                           WHERE kelas_id = ".$id);
        if ($query->num_rows() != 0) {
            $data['nilai_mahasiswas'] = $this->dosen_model->get_nilai_mahasiswa($id);
        };

        // $sql = ""
        // var_dump($data['nilai_mahasiswas']);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dosen/kelas', $data);
        $this->load->view('templates/footer');
    }

    public function assign_pj($kelas_id = NULL, $kode_kelas = '', $mahasiswa_id = '')
    {

        $this->db->set('mahasiswa_id', $mahasiswa_id);
        $this->db->where('id', $kelas_id);
        $this->db->update('kelas');

        $this->db->set('penanggungjawab', '1');
        $this->db->where('id', $mahasiswa_id);
        $this->db->update('mahasiswa');

        $this->session->set_flashdata('success', 'Berhasil!');
        redirect("dosen/" . $kode_kelas . "/" . $kelas_id);
    }

    public function pertemuan($id = NULL, $kode_kelas = NULL, $pertemuan_id = NULL)
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('kelas_model');
        $this->load->model('tugas_model');
        $data['kelas'] = $this->kelas_model->get_all_data($id)->result();

        $data['pertemuans'] = $this->kelas_model->get_pertemuan($id)->result();

        $i = 0;
        $data['kelas_mahasiswas'] = $this->kelas_model->get_kelas_mahasiswa($id)->result();
            $array_mahasiswa = array();
            foreach ($data['kelas_mahasiswas'] as $kelas_mahasiswa) :
                $ql2 = $this->db->get_where('presensi', ['kelas_id' => $id, 'mahasiswa_id' => $kelas_mahasiswa->mahasiswa_id, 'pertemuan_id' => $pertemuan_id]);
                $ql2_hadir = $ql2->row_array();
                array_push($array_mahasiswa, array(
                    "mahasiswa_id" => $kelas_mahasiswa->mahasiswa_id,
                    "nama_mahasiswa" => $kelas_mahasiswa->nama,
                    // "kelas_id" => $kelas_mahasiswa->kelas_id,
                    "hadir" => $ql2->num_rows() > 0 ? ($ql2_hadir['kehadiran'] == 0 ? 0 : 1) : 2
                ));
                // $array_mahasiswa[] = ['mahasiswa' => $isi_array_mahasiswa];
            endforeach;
        $array_mahasiswa_encode = json_encode($array_mahasiswa);
        $data['kehadiran_encode2'] = json_decode($array_mahasiswa_encode);

        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dosen/pertemuan', $data);
        $this->load->view('templates/footer');
        
    }
    
    public function tugas($kelas_id = NULL, $kode_kelas = '', $id = NULL)
    {

        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        // var_dump($kode_kelas);

        $this->load->model('kelas_model');
        $this->load->model('tugas_model');
        $data['kelas'] = $this->kelas_model->get_all_data($kelas_id)->result();
        $data['tugas'] = $this->tugas_model->get_data($kelas_id);
        $data['nilai'] = $this->tugas_model->get_nilai($id)->result();
        // var_dump($data['nilai']);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dosen/kelas_tugas', $data);
        $this->load->view('templates/footer');
    }


    public function tambah_tugas($kelas_id = NULL, $kode_kelas = '')
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('kelas_model');
        $data['mhskelas'] = $this->kelas_model->get_data_mhskelas($kelas_id)->result();
        $data['kelas'] = $this->kelas_model->get_all_data($kelas_id)->result();

        $this->form_validation->set_rules('tipe-tugas', 'Tipe Tugas', 'required', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('tugas-ke', 'Tugas Ke-', 'required|trim', [
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('bobot', 'Bobot', 'required|trim', [
            'min_length' => 'Password too short!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('dosen/tambah_tugas', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'nama_tugas' => $this->input->post('tugas-ke'),
                'tipe' => $this->input->post('tipe-tugas'),
                'bobot' => $this->input->post('bobot'),
                'kelas_id' => $kelas_id,
                'status_isi' => 0
            ];
            $this->db->insert('tugas', $data);
            $this->session->set_flashdata('success', 'Berhasil!');
            redirect("dosen/" . $kode_kelas . "/" . $kelas_id);
        }
    }

    public function tambah_nilai($kelas_id = NULL, $kode_kelas = '', $id = NULL)
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();
        $this->load->model('kelas_model');
        $data['mhskelas'] = $this->kelas_model->get_data_mhskelas($kelas_id)->result();
        $data['kelas_id'] = $kelas_id;
        $data['kode_kelas'] = $kode_kelas;
        $data['id'] = $id;
        $data['kelas'] = $this->kelas_model->get_all_data($kelas_id)->result();
        // var_dump($kelas_id);

        $this->form_validation->set_rules('nilai[]', 'Nilai', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('dosen/tambah_nilai', $data);
            $this->load->view('templates/footer');
        } else {
            $nilai = $this->input->post('nilai');
            $mhsid = $this->input->post('mhsid');
            for ($i = 0; $i < count($nilai); $i++) {
                $datas = [
                    [
                        'mahasiswa_id' => $mhsid[$i],
                        'tugas_id' => $id,
                        'nilai' => $nilai[$i]
                    ]
                ];
                $this->load->model('nilai_model');
                $this->nilai_model->tambah_nilai($datas, $id);
                
            }

            //predict kalo yang diisi uts

            $this->db->select('mahasiswa_id, kelas_id,
            avg(case when tipe = "Tugas" or tipe = "Kuis" then nilai else null end) as tugas,
            sum(case when tipe = "UTS" then nilai else null end) as uts,
            sum(case when tipe = "UAS" then nilai else null end) as uas');
            $this->db->from('nilai AS n');
            $this->db->join('mahasiswa AS m', 'm.id = n.mahasiswa_id', 'INNER');
            $this->db->join('tugas AS t', 't.id = n.tugas_id', 'INNER');
            $this->db->join('users AS u', 'u.id = m.user_id', 'left');
            $this->db->where('kelas_id', $kelas_id);
            $this->db->group_by('mahasiswa_id, kelas_id');
            $query3 = $this->db->get();
            $hasil3 = $query3->result();
            // var_dump($hasil3);

            $i = -1;
            $array = array();
            foreach ($hasil3 as $hsl) :
                if ($hsl->uts != null && $hsl->uas == null) {
                    $i++;
                    $array[$i][] = [$hsl->tugas, $hsl->uts];
                    //print_r($array[$i]);
                    $extractor = new CSV('assets/dataset_anreal.csv', true);
                    $dataset = Labeled::fromIterator($extractor)->apply(new NumericStringConverter());
                    [$training, $testing] = $dataset->stratifiedSplit(0.7);
                    //echo $dataset->labelType();
                    //var_dump($dataset);
                    //$validator = new HoldOut(0.2);
                    $estimator = new GaussianNB();
                    $validator = new HoldOut(0.3);
                    $estimator->train($dataset);
                    $datates = new Unlabeled($array[$i]);
                    $predictions = $estimator->predict($datates);
                    array_push($array[$i], array("mahasiswa_id" => $hsl->mahasiswa_id, "kelas_id" => $hsl->kelas_id, "warning" => $predictions));
                } 
            endforeach;
            $array_json = json_encode($array);
            $array_decode = (json_decode($array_json));
            var_dump($array_decode);

            $update_data = [];
            foreach ($array_decode as $value) {
                $this->db->set('warning', $value[1]->warning[0]);
                $this->db->where('mahasiswa_id', $value[1]->mahasiswa_id);
                $this->db->where('kelas_id', $kelas_id);
                $this->db->update('kelas_mahasiswa');
                // if ($this->db->where('warning', NULL)) {
                    // echo "yes";
                // }
            }


            // $i = -1;
            // $array_uas = array();
            // foreach ($hasil3 as $hsl) :
            //     if ($hsl->uas != null) {
            //         $i++;
            //         $array_uas[$i][] = [$hsl->tugas, $hsl->uts, $hsl->uas];
            //         //print_r($array[$i]);
            //         $extractor = new CSV('assets/dataset_anreal_csv_new.csv', true);
            //         $dataset = Labeled::fromIterator($extractor)->apply(new NumericStringConverter());
            //         [$training, $testing] = $dataset->stratifiedSplit(0.3);
            //         //echo $dataset->labelType();
            //         //var_dump($dataset);
            //         //$validator = new HoldOut(0.2);
            //         $estimator = new GaussianNB([3
            //         ], 1e-9);
            //         $validator = new HoldOut(0.4);
            //         $estimator->train($training);
            //         $datates = new Unlabeled($array_uas[$i]);
            //         $predictions = $estimator->predict($datates);
            //         array_push($array_uas[$i], array("mahasiswa_id" => $hsl->mahasiswa_id, "kelas_id" => $hsl->kelas_id, "warning" => $predictions));
            //     }
            // endforeach;
            // $array_uas_json = json_encode($array_uas);
            // $array_uas_decode = (json_decode($array_uas_json));
    
            // foreach ($array_uas_decode as $value_prediksi) {
            //     $this->db->set('warning', $value_prediksi[1]->warning[0]);
            //     $this->db->where('mahasiswa_id', $value_prediksi[1]->mahasiswa_id);
            //     $this->db->where('kelas_id', $kelas_id);
            //     $this->db->update('kelas_mahasiswa');
            //         // echo "yes";
            // }

            //sampe sini
            $this->session->set_flashdata('success', 'Berhasil!');
            redirect("dosen/" . $kode_kelas . "/" . $kelas_id);
        }
    }
}
