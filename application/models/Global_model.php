<?php
class Global_model extends CI_Model{
	public function insert($db_name, $insert_data){
        $insert = $this->db->insert($db_name, $insert_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
}

?>