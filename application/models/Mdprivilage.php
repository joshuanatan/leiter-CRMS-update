<?php
class Mdprivilage extends CI_Model{
    public function select($data){
        $this->db->join("menu","menu.id_menu = privilage.id_menu","inner");
        return $this->db->get_where("privilage",$data);
    }
    public function insert($data){
        $this->db->insert("privilage",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("privilage",$data,$where);
    }
    public function delete($where){
        $this->db->delete("privilage",$where);
    }
}
?>