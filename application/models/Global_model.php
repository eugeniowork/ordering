<?php
class Global_model extends CI_Model{
	public function insert($db_name, $insert_data){
        $insert = $this->db->insert($db_name, $insert_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get($db_name, $select = "*", $where = "", $order = [], $query_type = "result"){
        $this->db->select($select);
        $this->db->from($db_name);
        if($where != ""){
            $this->db->where($where);
        }
        if(!empty($order)){
            $this->db->order_by($order['column'], $order['type']);
        }
        $query = $this->db->get();

        if($query_type == "multiple"){
            return $query->result();
        }
        else if($query_type == "single"){
            return $query->row_array();
        }
        
    }

    public function update($db_name, $where = "", $update_data){
        $this->db->where($where);
        $this->db->update($db_name,$update_data);
        return true;
    }
}

?>