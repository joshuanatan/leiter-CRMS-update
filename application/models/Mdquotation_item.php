<?php
class Mdquotation_item extends CI_Model{
    public function select($data){
        $this->db->join("price_request_item","price_request_item.id_request_item = quotation_item.id_request_item","inner");
        return $this->db->get_where("quotation_item",$data);
    }
    public function insert($data){
        $this->db->insert("quotation_item",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("quotation_item",$data,$where);
    }
    public function delete($where){
        $this->db->delete("quotation_item",$where);
    }
    public function countAllPrice($where){
        $this->db->select("sum(selling_price) as totalTagihan");
        $this->db->Where($where);
        return $this->db->get("quotation_item");
    }
    /**************************************************************** */
    public function getListQuotationItem($where){
        $this->db->select("*");
        $this->db->select("harga_vendor.harga_produk as harga_shipping,harga_vendor.harga_produk as harga_shipping,harga_courier.harga_produk as harga_courier,harga_vendor.vendor_price_rate as vendor_price_rate,harga_shipping.vendor_price_rate as shipping_price_rate,harga_courier.vendor_price_rate as courier_price_rate,harga_vendor.id_perusahaan as id_vendor,harga_vendor.id_perusahaan as id_shipper,harga_courier.id_perusahaan as id_courier, quotation_item.attachment as product_image");
        $this->db->join("harga_vendor","harga_vendor.id_harga_vendor = quotation_item.id_harga_vendor","inner");
        $this->db->join("harga_shipping","harga_shipping.id_harga_shipping = quotation_item.id_harga_shipping","inner");
        $this->db->join("harga_courier","harga_courier.id_harga_courier = quotation_item.id_harga_courier","inner");
        $this->db->join("price_request_item","price_request_item.id_request_item = quotation_item.id_request_item","inner");
        return $this->db->get_where("quotation_item",$where);
    }
}
?>