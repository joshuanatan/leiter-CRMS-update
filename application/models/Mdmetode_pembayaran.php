<?php
class Mdmetode_pembayaran extends CI_Model{
    public function select($data){
        return $this->db->get_where("metode_pembayaran",$data);
    }
    public function insert($data){
        $this->db->insert("metode_pembayaran",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("metode_pembayaran",$data,$where);
    }
    public function delete($where){
        $this->db->delete("metode_pembayaran",$where);
    }
    /************************************************* */
    public function getListQuotationMetodePembayaran($where){
        return $this->db->get_where("quotation_metode_pembayaran",$where);
    }
}
?>