<?php
class Mdmata_uang extends CI_Model{
    public function select($data){
        return $this->db->get_where("mata_uang",$data);
    }
    public function insert($data){
        $this->db->insert("mata_uang",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("mata_uang",$data,$where);
    }
    public function delete($where){
        $this->db->delete("mata_uang",$where);
    }
}
?>