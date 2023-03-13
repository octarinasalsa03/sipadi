<?php

class Nilai_model extends CI_model 
{
    public function tambah_nilai($datas, $id)
    {
        $this->db->insert_batch('nilai', $datas);
        $this->db->set('status_isi', 1);
        $this->db->where('id', $id);
        $this->db->update('tugas');
    }
}