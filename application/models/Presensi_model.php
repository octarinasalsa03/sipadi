<?php

class Presensi_model extends CI_model 
{
    public function isi_presensi($datas)
    {
        $this->db->insert('presensi', $datas);
    }
}