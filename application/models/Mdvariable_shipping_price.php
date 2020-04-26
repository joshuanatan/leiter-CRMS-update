<?php
class Mdvariable_shipping_price extends CI_Model{
    public function select($data){
        return $this->db->get_where("variable_shipping_price",$data);
    }
    public function insert($data){
        $this->db->insert("variable_shipping_price",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("variable_shipping_price",$data,$where);
    }
    public function delete($where){
        $this->db->delete("variable_shipping_price",$where);
    }
    public function selectVendorShipping($where){
        $this->db->group_by(array("variable_shipping_price.id_perusahaan","metode_pengiriman"));
        return $this->db->get_where("variable_shipping_price",$where);
    }
    public function selectShippers($where){
        $this->db->join("perusahaan","perusahaan.id_perusahaan = variable_shipping_price.id_perusahaan","inner");
        $this->db->group_by(array("variable_shipping_price.id_perusahaan","metode_pengiriman"));
        $this->db->group_by("perusahaan.id_perusahaan");
        return $this->db->get_where("variable_shipping_price",$where);
        /*
        SELECT * FROM `variable_shipping_price` inner join perusahaan on perusahaan.id_perusahaan = variable_shipping_price.id_perusahaan WHERE id_supplier = 4 and variable_shipping_price.id_request_item = 42 group by variable_shipping_price.id_perusahaan and metode_pengiriman
        */
    }
    public function countPrice($where){
        $this->db->select("sum(biaya_variable*kurs_variable) as 'total'");
        return $this->db->get_where("variable_shipping_price",$where);
    }
    
}
?>