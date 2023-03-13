<?php

class Admin_model extends CI_model 
{
    public function tambah_kelas($datas)
    {
        $this->db->insert('kelas', $datas);
    }
}