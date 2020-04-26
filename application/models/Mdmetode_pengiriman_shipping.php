<?php
class Mdmetode_pengiriman_shipping extends CI_Model{
    public function select($data){
        return $this->db->get_where("metode_pengiriman_shipping",$data);
    }
    public function insert($data){
        $this->db->insert("metode_pengiriman_shipping",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("metode_pengiriman_shipping",$data,$where);
    }
    public function delete($where){
        $this->db->delete("metode_pengiriman_shipping",$where);
    }
}
?>