<?php
class Global_model extends CI_Model{
	public function insert($db_name, $insert_data){
        $insert = $this->db->insert($db_name, $insert_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function batch_insert_or_update($db_name, $insert_data){
        $insert = $this->db->insert_on_duplicate_update_batch($db_name,$insert_data);
        return $insert;
    }

    public function get($db_name, $select = "*", $where = "", $order = [], $query_type = "result", $limit = []){
        $this->db->select($select);
        $this->db->from($db_name);
        if($where != ""){
            $this->db->where($where);
        }
        if(!empty($order)){
            $this->db->order_by($order['column'], $order['type']);
        }

        if(!empty($limit)){
            $this->db->limit($limit['limit'], $limit['limit_start']);
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

    public function delete($db_name, $where = ""){
        $this->db->where($where);
        $this->db->delete($db_name);
        return true;
    }
}

?>