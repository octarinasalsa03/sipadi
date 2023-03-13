<?php

class Dosen_model extends CI_model 
{
    // public function get_nilai_mahasiswa()
    // {
    //     // $this->db->query("
    //     // SELECT
    //     //   GROUP_CONCAT(DISTINCT
    //     //     CONCAT(
    //     //       'max(case when col = ''',
    //     //       col,
    //     //       ''' then value end) as `', 
    //     //       col, '`')
    //     //   ) INTO @sql
    //     // FROM
    //     // (
    //     //   select `nama_tugas` col
    //     //   from nilai_tugas
    //     // )d;
        
    //     // SET @sql = CONCAT('SELECT mahasiswa_id, ', @sql, ' 
    //     //                   from
    //     //                   (
    //     //                     select mahasiswa_id, nama_tugas col,  nilai value
    //     //                     from nilai_tugas
    //     //                   ) d
    //     //                   group by mahasiswa_id');
        
    //     // PREPARE stmt FROM @sql;
    //     // EXECUTE stmt;
    //     // DEALLOCATE PREPARE stmt;");
    //     $query = $this->db->query("CALL all_nilai_mahasiswa()");
    //     return $query->result_array();
    // }

    public function get_nilai_mahasiswa($kelas_id) 
    {
        $this->db->query('SET @sql = NULL');
        $this->db->query("
        SELECT
        GROUP_CONCAT(DISTINCT
            CONCAT(
                'max(case when col = ''',
                col,
                ''' then value end) as `', 
                col, '`')
        ) INTO @sql
        FROM (
            select `nama_tugas` col
            from (select `id20194748_spd`.`nilai`.`id` AS `id`,`id20194748_spd`.`nilai`.`mahasiswa_id` AS `mahasiswa_id`,`id20194748_spd`.`nilai`.`tugas_id` AS `tugas_id`,`id20194748_spd`.`users`.`nama` AS `Nama`,`id20194748_spd`.`tugas`.`nama_tugas` AS `nama_tugas`,`id20194748_spd`.`tugas`.`tipe` AS `tipe`,`id20194748_spd`.`tugas`.`bobot` AS `bobot`,`id20194748_spd`.`tugas`.`kelas_id` AS `kelas_id`,`id20194748_spd`.`nilai`.`nilai` AS `nilai` from (((`id20194748_spd`.`tugas` join `id20194748_spd`.`nilai` on(`id20194748_spd`.`tugas`.`id` = `id20194748_spd`.`nilai`.`tugas_id`)) left join `id20194748_spd`.`mahasiswa` on(`id20194748_spd`.`mahasiswa`.`id` = `id20194748_spd`.`nilai`.`mahasiswa_id`)) left join `id20194748_spd`.`users` on(`id20194748_spd`.`users`.`id` = `id20194748_spd`.`mahasiswa`.`user_id`))) nt
            where `kelas_id` = " . $kelas_id . "
          ) d;"

        );
               
        $this->db->query("SET @sql = CONCAT('SELECT 
        Nama, ', @sql, ' 
        FROM 
        (
            select mahasiswa_id, Nama, nama_tugas col, nilai value
            FROM (select `id20194748_spd`.`nilai`.`id` AS `id`,`id20194748_spd`.`nilai`.`mahasiswa_id` AS `mahasiswa_id`,`id20194748_spd`.`nilai`.`tugas_id` AS `tugas_id`,`id20194748_spd`.`users`.`nama` AS `Nama`,`id20194748_spd`.`tugas`.`nama_tugas` AS `nama_tugas`,`id20194748_spd`.`tugas`.`tipe` AS `tipe`,`id20194748_spd`.`tugas`.`bobot` AS `bobot`,`id20194748_spd`.`tugas`.`kelas_id` AS `kelas_id`,`id20194748_spd`.`nilai`.`nilai` AS `nilai` from (((`id20194748_spd`.`tugas` join `id20194748_spd`.`nilai` on(`id20194748_spd`.`tugas`.`id` = `id20194748_spd`.`nilai`.`tugas_id`)) left join `id20194748_spd`.`mahasiswa` on(`id20194748_spd`.`mahasiswa`.`id` = `id20194748_spd`.`nilai`.`mahasiswa_id`)) left join `id20194748_spd`.`users` on(`id20194748_spd`.`users`.`id` = `id20194748_spd`.`mahasiswa`.`user_id`))) nt 
            where kelas_id = " . $kelas_id . "
        ) d
        GROUP BY mahasiswa_id');");
        $this->db->query("PREPARE stmt FROM @sql");
        $res = $this->db->query("EXECUTE stmt;");
        return $res->result_array();

    }

    public function get_dosen($user_id)
    {
        $this->db->select('dosen.*, users.nama, users.email');
        $this->db->from('dosen');
        $this->db->join('users', 'users.id = dosen.user_id');
        $this->db->where('dosen.user_id', $user_id);
        $result = $this->db->get();
        return $result->result_array();
    }
}