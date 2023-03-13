<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require_once __DIR__ . '\vendor\autoload.php';
require './vendor/autoload.php';

use Rubix\ML\Classifiers\GaussianNB;
use Rubix\ML\Classifiers\NaiveBayes;
use Rubix\ML\CrossValidation\HoldOut;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\CrossValidation\Metrics\MeanAbsoluteError;


//use Phpml\Classification\NaiveBayes;

class Coba extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //php-ml
        // $samples = [[5, 1, 1], [1, 5, 1], [1, 1, 5]];
        // $labels = ['a', 'b', 'c'];

        // $classifier = new NaiveBayes();
        // $classifier->train($samples, $labels);

        // $classifier->predict([3, 1, 1]);
        // return 'a'

        // $predict = $classifier->predict([[3, 1, 1], [1, 4, 1]]);
        // var_dump($predict);
        // return ['a', 'b']

        // $samples = [
        //     [3, 4, 50.5],
        //     [1, 5, 24.7],
        //     [4, 4, 62.0],
        //     [3, 2, 31.1],
        // ];
        // $labels = ['married', 'divorced', 'married', 'divorced'];

        // $newsample = [
        //     [4, 3, 44.2],
        //     [2, 2, 16.7],
        //     [2, 4, 19.5],
        //     [3, 3, 55.0],
        // ];
        // $dataset = new Labeled($samples, $labels);
        // echo $dataset->labelType();
        // $estimator = new GaussianNB([], 1e-9);
        // $estimator->train($dataset);
        // $newdataset = new Unlabeled($newsample);
        // $predictions = $estimator->predict($newdataset);
        // // $validator = new HoldOut(0.2);
        // // $score = $validator->test($estimator, $dataset, new Accuracy());
        // print_r($predictions);
        // print_r($score);


        $extractor = new CSV('assets/dataset_anreal_csv_new.csv', true);
        $dataset = Labeled::fromIterator($extractor)->apply(new NumericStringConverter());
        // var_dump($dataset);
        [$training, $testing] = $dataset->stratifiedSplit(0.4);
        // print_r($training);
        // print_r($dataset);
        //echo $dataset->labelType();
        //var_dump($dataset);
        // [$training, $testing] = $dataset->stratifiedSplit(0.5);
        // $estimator = new NaiveBayes([]);
        $estimator = new GaussianNB([3
        ], 1e-9);
        $validator = new HoldOut(0.4);
        $test = [
            [65, 50, 90],
        ];
        $estimator->train($training);
        // //var_dump($estimator->trained());
        $datates = new Unlabeled($test);
        $accuracy = new Accuracy();
        $predictions = $estimator->predict($datates);
        // $prediction = $estimator->predict($testing);
        // $scoreNum = $accuracy->score($predictions, $testing->labels());
        // $metric = new MeanAbsoluteError();
        // $score = $metric->score($testing, $dataset->labels());
        $score = $validator->test($estimator, $dataset, new Accuracy());
        // echo $score;
        print_r($predictions);
        // print_r($testing->labels());
        print_r($score);
        // dd($predictions);
    }

    public function test()
    {
        // $this->db->select('mahasiswa_id');
        // $this->db->distinct();
        // $this->db->where('tipe', 'UAS');
        // $query = $this->db->get('view_nilai');
        // $hasil = $query->result();
        // print_r($hasil);

        // $this->db->select('vn.mahasiswa_id, vn.user_id, vn.nim, vn.kelas_id, 
        // group_concat(tipe_dan_nilai) tipe_nilai');
        // $this->db->from('(SELECT view_nilai.mahasiswa_id, view_nilai.user_id, view_nilai.nim, view_nilai.kelas_id, 
        // concat(view_nilai.tipe, ":", sum(view_nilai.nilai)/count(view_nilai.tipe)) tipe_dan_nilai
        // FROM view_nilai 
        // WHERE view_nilai.tipe = "Tugas" OR view_nilai.tipe = "UTS"
        // GROUP BY view_nilai.mahasiswa_id, view_nilai.tipe) vn');
        // $this->db->where('vn.kelas_id = 1');
        // $this->db->group_by('vn.mahasiswa_id');
        // $query2 = $this->db->get();
        // $hasil2 = $query2->result();
        //var_dump($hasil2[0]);

        $this->db->select('mahasiswa_id, kelas_id,
        avg(case when tipe = "Tugas" then nilai else null end) as tugas,
        sum(case when tipe = "UTS" then nilai else null end) as uts,
        sum(case when tipe = "UAS" then nilai else null end) as uas');
        $this->db->from('view_nilai');
        $this->db->group_by('view_nilai.mahasiswa_id, view_nilai.kelas_id');
        $query3 = $this->db->get();
        $hasil3 = $query3->result();
        var_dump($hasil3);
        foreach ($hasil3 as $hasil) :
            print_r($hasil->uts);
        endforeach;

        $i = -1;
        $array = array();
        foreach ($hasil3 as $hsl) :
            if ($hsl->uts != null) {
                $i++;
                $array[$i][] = [$hsl->tugas, $hsl->uts];
                $extractor = new CSV('assets/dataset_anreal.csv', true);
                $dataset = Labeled::fromIterator($extractor);
                //echo $dataset->labelType();
                //var_dump($dataset);
                //$validator = new HoldOut(0.2);
                $estimator = new NaiveBayes([], 1.5);
                $estimator->train($dataset);

                $datates = new Unlabeled($array[$i]);
                $predictions = $estimator->predict($datates);
                array_push($array[$i], array("mahasiswa_id" => $hsl->mahasiswa_id, "kelas_id" => $hsl->kelas_id, "warning" => $predictions));
            }
        //print_r($array[$i]);
        //array_push($array[$i], $predictions);
        //print_r($array);

        // $array = [[$hsl->tugas, $hsl->uts]];
        // print_r($array);
        endforeach;

        $array_json = json_encode($array);
        $array_decode = json_decode($array_json);
        //var_dump($array_decode);
        // foreach ($array_decode as $item) {
        //     print_r($item[1]->warning);
        // }

        // $kelas_id = "1";
        // $update_data = [];
        // //print_r($array_decode[0][1]->warning[0]);
        // foreach ($array_decode as $value) {
        //     $this->db->set('warning', $value[1]->warning[0]);
        //     $this->db->where('mahasiswa_id', $value[1]->mahasiswa_id);
        //     if ($this->db->where('warning', '')) {
        //         $this->db->update('kelas_mahasiswa');
        //         echo "yes";
        //     }
        //     // $this->db->where('kelas_id', null);
        //     // $where = array('mahasiswa_id' => $value[1]->mahasiswa_id, 'kelas_id' => $kelas_id, 'warning' => null);
        //     // if ($this->db->where($where)) {
        //     //     $this->db->set('warning', 'kelas');
        //     //     $this->db->update('kelas_mahasiswa');
        //     //     echo "yes";
        //     // }
        // }

        // print_r($value[1]->warning);
        // $update_data[] = [
        //     'mahasiswa_id'    => $value[1]->mahasiswa_id,
        //     'warning'    => $value[1]->warning[0],
        // ];
        //}
        // var_dump($update_data);
        // die;

        // $data = array(
        //     array(
        //         'mahasiswa_id' => 1,
        //         'warning' => 'My Name 2'
        //     ),
        //     array(
        //         'mahasiswa_id' => 2,
        //         'warning' => 'Another Name 2',
        //     )
        // );

        // $this->db->where(array('kelas_id' => $kelas_id, 'warning' => null));
        // if ($this->db->update_batch('kelas_mahasiswa', $update_data, 'mahasiswa_id') == true) {
        //     echo "yes";
        // } else {
        //     echo "no";
        // }
        // if ($this->some_model->batch_data('records', $update_data) == true) {
        //     echo "yes";
        // } else {
        //     echo "no";
        // }


        $test = [
            [40, 70]
        ];
        //print_r($test);

        //var_dump($estimator->trained());
        // $datates = new Unlabeled($array);
        // //$score = $validator->test($estimator, $dataset, new Accuracy());
        // $predictions = $estimator->predict($datates);
        //echo $score;
        // print_r($predictions);



        // print_r($hasil[0]->mahasiswa_id );

        // for ($i = 0; $i < count($hasil); $i++) {
        //     var_dump($hasil[$i]->mahasiswa_id);
        // }
    }
}
