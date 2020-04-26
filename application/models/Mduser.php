<?php
class Mduser extends CI_Model{
    public function select($data){
        $this->db->where("user.id_user in (select tipe_user.id_user from tipe_user)");
        return $this->db->get_where("user",$data);
    }
    public function insert($data){
        $this->db->insert("user",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("user",$data,$where);
    }
    public function delete($where){
        $this->db->delete("user",$where);
    }
    public function insertTipe($data){
        $this->db->insert("tipe_user",$data);
    }
}
?>