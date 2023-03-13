<?php

class Mahasiswa_model extends CI_model
{
    public function get_data_kelas($kode_kelas)
    {
        $this->db->select('kelas.id, kelas.kode, kelas.hari, DATE_FORMAT(kelas.waktu, "%H:%i") AS waktu, kelas.semester, kelas.matakuliah_id, kelas.dosen_id, kelas.mahasiswa_id, matakuliah.nama, matakuliah.sks');
        $this->db->from('kelas');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id');
        $this->db->where('kode', $kode_kelas);
        return $this->db->get();
    }
    public function get_data_nilai($mahasiswa_id, $kelas_id)
    {
        // return $this->db->get_where('view_nilai', array('mahasiswa_id' => $mahasiswa_id))->result_array();
        $this->db->select('*');
        $this->db->from('nilai AS n'); // I use aliasing make joins easier
        $this->db->join('mahasiswa AS m', 'm.id = n.mahasiswa_id', 'INNER');
        $this->db->join('tugas AS t', 't.id = n.tugas_id', 'INNER');
        $this->db->join('users AS u', 'u.id = m.user_id', 'left');
        $this->db->where(array(
            'mahasiswa_id' => $mahasiswa_id,
            'kelas_id' => $kelas_id
        ));
        return $this->db->get();
    }

    public function get_pertemuan($kelas_id)
    {
        $this->db->select('*');
        $this->db->from('pertemuan');
        $this->db->where('kelas_id', $kelas_id);
        return $this->db->get();
    }

    public function get_kehadiran($mahasiswa_id, $kelas_id)
    {
        $this->db->select('*');
        $this->db->from('pertemuan');
        $this->db->join('presensi', 'presensi.pertemuan_id = pertemuan.id');
        $this->db->where(array(
            'presensi.mahasiswa_id' => $mahasiswa_id,
            'presensi.kelas_id' => $kelas_id,
        ));
        return $this->db->get();
    }

    public function get_kelas($mahasiswa_id)
    {
        $this->db->select('kelas_mahasiswa.*, kelas.kode, matakuliah.nama, matakuliah.sks');
        $this->db->from('kelas_mahasiswa');
        $this->db->join('kelas', 'kelas.id = kelas_mahasiswa.kelas_id');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id', 'left');
        $this->db->where('kelas_mahasiswa.mahasiswa_id', $mahasiswa_id);
        return $this->db->get();
    }

    public function get_kelas_mahasiswa($mahasiswa_id, $kelas_id)
    {
        $this->db->select('kelas_mahasiswa.*, kelas.kode, matakuliah.nama');
        $this->db->from('kelas_mahasiswa');
        $this->db->join('kelas', 'kelas.id = kelas_mahasiswa.kelas_id');
        $this->db->join('matakuliah', 'matakuliah.id = kelas.matakuliah_id', 'left');
        $this->db->where(array(
            'kelas_mahasiswa.mahasiswa_id' => $mahasiswa_id,
            'kelas_mahasiswa.kelas_id' => $kelas_id,
        ));
        return $this->db->get();
    }

    public function get_mahasiswa($user_id)
    {
        // $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->select('mahasiswa.*, users.nama, users.email');
        $this->db->from('mahasiswa');
        $this->db->join('users', 'users.id = mahasiswa.user_id');
        $this->db->where('mahasiswa.user_id', $user_id);
        $result = $this->db->get();
        return $result->result_array();

    }
}
