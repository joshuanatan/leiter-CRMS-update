<?php
class Mdsatuan extends CI_Model{
    public function select($data){
        $this->db->group_by("nama_satuan");
        return $this->db->get_where("satuan",$data);
    }
    public function insert($data){
        $this->db->insert("satuan",$data);
    }
    public function update($data,$where){
        $this->db->update("satuan",$data,$where);
    }
    public function delete($where){
        $this->db->delete("satuan",$where);
    }
}
?>