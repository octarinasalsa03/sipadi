<?php

class Pertemuan_model extends CI_model 
{
    public function tambah_pertemuan($datas)
    {
        $this->db->insert('pertemuan', $datas);
    }
}