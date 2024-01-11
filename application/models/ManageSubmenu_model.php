<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManageSubmenu_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function show_main_menu()
    {
        $sql_show_main = "SELECT smm_id, smm_name FROM sys_main_menu";
        $query = $this->db->query($sql_show_main);
        $data = $query->result();

        return $data;
    }


    public function show_submenu($data)
{
    if (isset($data["mainId"]) && !empty($data["mainId"])) {
        $id = $data["mainId"];

        $sql = "SELECT * FROM sys_sub_menu WHERE smm_id = '$id';";

        $query = $this->db->query($sql);
        $data = $query->result();

        // Loop through the result and replace null values with '-'
        foreach ($data as &$row) {
            foreach ($row as $key => $value) {
                if ($value === null) {
                    $row->$key = '-';
                }
            }
        }

        return $data;
    } else {
        // Handle the case where 'mainId' is not set or empty
        return null;
    }
}

}