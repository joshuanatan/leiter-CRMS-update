<?php
class Mdmenu extends CI_Model{
    public function select($data){
        return $this->db->get_where("menu",$data);
    }
    public function insert($data){
        $this->db->insert("menu",$data);
    }
    public function update($data,$where){
        $this->db->update("menu",$data,$where);
    }
    public function delete($where){
        $this->db->delete("menu",$where);
    }
    public function selectType($where){
        $this->db->group_by("type_menu");
        return $this->db->get_where("menu",$where);
    }
}
?>