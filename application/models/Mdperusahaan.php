<?php
class Mdperusahaan extends CI_Model{
    public function select($where,$field = "",$limit = ""){
        if($field != ""){
            $this->db->select($field);
        }
        if($limit != ""){
            $this->db->limit($limit);
        }
        $this->db->join("contact_person","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->group_by("perusahaan.id_perusahaan");
        $this->db->order_by("nama_perusahaan","ASC");
        return $this->db->get_where("perusahaan",$where);
    }
    public function insert($data){
        $this->db->insert("perusahaan",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("perusahaan",$data,$where);
    }
    public function delete($where){
        $this->db->delete("perusahaan",$where);
    }
    public function itemsupplier($data){
        $this->db->join("price_request","price_request.id_request = price_request_item.id_request","inner");
        $this->db->join("produk","produk.id_produk = price_request_item.id_produk","inner");
        $this->db->join("produk_vendor","produk_vendor.id_produk = produk.id_produk","inner");
        $this->db->join("perusahaan","perusahaan.id_perusahaan = produk_vendor.id_perusahaan","inner");
        $this->db->join("contact_person","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->group_by("perusahaan.id_perusahaan");
        $this->db->where("status_produk_vendor",0);
        $this->db->where("status_perusahaan",0);
        return $this->db->get_where("price_request_item",$data);
    }
    /* dari sini kebawah, itu yang kepake di sistem setelah review menjelang terakhir*/
    public function getListPerusahaan($where){
        $this->db->where("status_perusahaan",0); /*yang aktif*/
        $this->db->order_by("nama_perusahaan","ASC");
        return $this->db->get_where("perusahaan",$where); /*bisa jadi di pilih per segment atau yang tidak permanen dsb*/
    }
}
?>