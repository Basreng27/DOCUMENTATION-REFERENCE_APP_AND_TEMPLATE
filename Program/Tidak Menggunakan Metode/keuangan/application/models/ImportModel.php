<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImportModel extends CI_Model
{

    public function insert($data)
    {
        $insert = $this->db->insert_batch('mahasiswa', $data);
        if ($insert) {
            return true;
        }
    }

    public function insert_akun($data)
    {
        $insert = $this->db->insert_batch('akun', $data);
        if ($insert) {
            return true;
        }
    }
    // public function getData()
    // {
    //     $this->db->select('*');
    //     return $this->db->get('tbl_data2')->result_array();
    // }
}
