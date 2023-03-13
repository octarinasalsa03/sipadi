<?php

class Tugas_model extends CI_model
{
    public function get_data($kelas_id)
    {
        return $this->db->get_where('tugas', array('kelas_id' => $kelas_id))->result_array();
    }

    public function get_nilai($tugas_id)
    {
        // $this->db->select('*');
        // $this->db->from('view_nilai');
        // $this->db->join('users', 'view_nilai.user_id = users.id');
        // $this->db->where('tugas_id', $tugas_id);
        // return $this->db->get();

        $this->db->select('*');
        $this->db->from('nilai AS n'); // I use aliasing make joins easier
        $this->db->join('mahasiswa AS m', 'm.id = n.mahasiswa_id', 'INNER');
        $this->db->join('tugas AS t', 't.id = n.tugas_id', 'INNER');
        $this->db->join('users AS u', 'u.id = m.user_id', 'left');
        $this->db->where('tugas_id', $tugas_id);
        return $this->db->get();

        // return $this->db->get_where('nilai_view', array('id' => $tugas_id))->result_array();

    }
}
