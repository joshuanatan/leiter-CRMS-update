<?php
class Mdvariable_courier_price extends CI_Model{
    public function select($data){
        return $this->db->get_where("variable_courier_price",$data);
    }
    public function insert($data){
        $this->db->insert("variable_courier_price",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("variable_courier_price",$data,$where);
    }
    public function delete($where){
        $this->db->delete("variable_courier_price",$where);
    }
    public function selectVendorShipping($where){
        $this->db->join("perusahaan","perusahaan.id_perusahaan = variable_courier_price.id_perusahaan","inner");
        $this->db->group_by(array("variable_courier_price.id_perusahaan","metode_pengiriman"));
        return $this->db->get_where("variable_courier_price",$where);
    }
    public function countPrice($where){
        $this->db->select("sum(biaya_variable*kurs_variable) as 'total'");
        return $this->db->get_where("variable_courier_price",$where);
    }
}
?>