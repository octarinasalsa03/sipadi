<?php

class User_model extends CI_model
{
    public function login($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }


    public function get($id = null) 
    {
        $this->db->from('users');
        if($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

}