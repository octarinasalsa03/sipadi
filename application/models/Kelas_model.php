<?php

class Kelas_model extends CI_model
{

    public function get_kelas()
    {
        $this->db->select('kelas.id, kelas.kode, kelas.hari, DATE_FORMAT(kelas.waktu, "%H:%i") AS waktu, kelas.semester, kelas.matakuliah_id, kelas.dosen_id, kelas.mahasiswa_id, matakuliah.nama, matakuliah.sks, users.nama AS nama_dosen');
        $this->db->from('kelas');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id');
        $this->db->join('dosen', 'dosen.id = kelas.dosen_id');
        $this->db->join('users', 'users.id = dosen.user_id', 'left');
        return $this->db->get();
    }

    public function get_data($user_id)
    {
        $dosen = $this->db->get_where('dosen', array('user_id' => $user_id))->row_array();
        $dosen_id = $dosen['id'];

        $this->db->select('kelas.*, matakuliah.nama, matakuliah.sks');
        $this->db->from('kelas');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id');
        $this->db->where('dosen_id', $dosen_id);
        return $this->db->get();
    }

    public function get_all_data($id)
    {
        $this->db->select('kelas.id, kelas.kode, kelas.hari, DATE_FORMAT(kelas.waktu, "%H:%i") AS waktu, kelas.semester, kelas.matakuliah_id, kelas.dosen_id, kelas.mahasiswa_id, matakuliah.nama, matakuliah.sks');
        $this->db->from('kelas');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id');
        $this->db->where('kelas.id', $id);
        return $this->db->get();
    }

    public function get_data_mhskelas($kelas_id)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_kelas');
        $this->db->join('users', 'mahasiswa_kelas.user_id = users.id');
        $this->db->where('kelas_id', $kelas_id);
        return $this->db->get();

        // return $this->db->get_where('nilai_view', array('id' => $tugas_id))->result_array();
    }

    public function get_mhskelas($kode_kelas)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_kelas');
        $this->db->where('kode', $kode_kelas);
        return $this->db->get();
    }
    
    public function get_mahasiswakelas($kode_kelas)
    {
        $this->db->select('km.*, m.*, k.kode, k.hari, k.waktu, k.matakuliah_id, k.dosen_id, k.mahasiswa_id AS pj_kelas');
        $this->db->from('kelas_mahasiswa AS km');
        $this->db->join('mahasiswa AS m', 'm.id = km.mahasiswa_id', 'INNER');
        $this->db->join('kelas AS k', 'k.id = km.kelas_id', 'INNER');
        $this->db->where('k.kode', $kode_kelas);
        return $this->db->get();
    }

    public function get_kelas_mahasiswa($kelas_id)
    {
        $this->db->select('km.*, m.*, k.kode, k.hari, k.waktu, k.matakuliah_id, k.dosen_id, k.mahasiswa_id AS pj_kelas, u.nama, u.email');
        $this->db->from('kelas_mahasiswa AS km');
        $this->db->join('mahasiswa AS m', 'm.id = km.mahasiswa_id', 'INNER');
        $this->db->join('kelas AS k', 'k.id = km.kelas_id', 'INNER');
        $this->db->join('users AS u', 'u.id = m.user_id', 'left');
        $this->db->where('km.kelas_id', $kelas_id);
        return $this->db->get();
    }

    public function get_pertemuan($kelas_id)
    {
        $this->db->select('*');
        $this->db->from('pertemuan');
        $this->db->where('kelas_id', $kelas_id);
        return $this->db->get();
    }
}
