<?php
class Mdprice_request_item extends CI_Model{
    
    public function select($where){
        $this->db->group_by("id_produk");
        return $this->db->get_where("price_request_item",$where);

    }
    public function insert($data){
        $this->db->insert("price_request_item",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("price_request_item",$data,$where);
    }
    public function delete($where){
        $this->db->delete("price_request_item",$where);
    }
    public function selectFullPrice($where){
        $this->db->join("price_request","price_request.id_request = price_request_item.id_request","inner");
        $this->db->join("produk","produk.id_produk = price_request_item.id_produk","inner");
        $this->db->join("produk_vendor","produk_vendor.id_produk = produk.id_produk","inner");
        $this->db->join("perusahaan","perusahaan.id_perusahaan = produk_vendor.id_perusahaan","inner");
        $this->db->join("contact_person","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->join("harga_vendor","harga_vendor.id_request_item = price_request_item.id_request_item","inner");
        $this->db->join("variable_shipping_price","variable_shipping_price.id_request_item = price_request_item.id_request_item","inner");
        $this->db->join("variable_courier_price","variable_courier_price.id_request_item = price_request_item.id_request_item","inner");
        $this->db->group_by("price_request_item.id_request_item");
        return $this->db->get_where("price_request_item",$where);
    }
    public function select2($data){ /*belum tau fungsinya buat apa*/
        $this->db->join("price_request","price_request.id_request = price_request_item.id_request","inner");
        $this->db->join("produk","produk.id_produk = price_request_item.id_produk","inner");
        $this->db->join("produk_vendor","produk_vendor.id_produk = produk.id_produk","inner");
        $this->db->join("perusahaan","perusahaan.id_perusahaan = produk_vendor.id_perusahaan","inner");
        $this->db->join("contact_person","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->group_by("price_request_item.id_request_item");
        return $this->db->get_where("price_request_item",$data);

        /*
        query = SELECT * FROM `price_request_item` inner join price_request on price_request.id_request = price_request_item.id_request inner join produk on produk.id_produk = price_request_item.id_produk inner join produk_vendor on produk_vendor.id_produk = produk.id_produk inner join perusahaan on perusahaan.id_perusahaan = produk_vendor.id_perusahaan inner join contact_person on contact_person.id_perusahaan = perusahaan.id_perusahaan where price_request_item.id_request_item = 43 group by price_request_item.id_request_item
        */
    }
}
?>