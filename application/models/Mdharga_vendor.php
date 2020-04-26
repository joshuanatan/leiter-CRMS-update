<?php
class Mdharga_vendor extends CI_Model{
    public function select($data){
        $this->db->join("perusahaan","perusahaan.id_perusahaan = harga_vendor.id_perusahaan","inner");
        return $this->db->get_where("harga_vendor",$data);
        
    }
    public function insert($data){
        $this->db->insert("harga_vendor",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("harga_vendor",$data,$where);
    }
    public function delete($where){
        $this->db->delete("harga_vendor",$where);
    }
    public function selectPenawaran($where){
        $this->db->join("produk","produk.id_produk = produk_vendor.id_produk","inner"); /*untuk tau detail produknya*/
        $this->db->join("price_request_item","price_request_item.id_produk = produk.id_produk","inner"); /*nyaring dengan yang dipesan*/
        $this->db->join("harga_vendor","harga_vendor.id_request_item = price_request_item.id_request_item","inner"); /*sambungin ke harga vendor sesuai barang yang dipesan */
        $this->db->join("contact_person","contact_person.id_cp = harga_vendor.id_cp","inner"); /*detail contact person */
        $this->db->join("perusahaan","perusahaan.id_perusahaan = contact_person.id_perusahaan","inner"); /*untuk tau detail perusahaan*/
        $this->db->group_by("harga_vendor.id_cp");
        return $this->db->get_where("produk_vendor",$where); /*menghubungkan antar produk dan vendor*/

        //query = SELECT * FROM `produk_vendor` /*menghubungkan antar produk dan vendor*/ inner join produk on produk.id_produk = produk_vendor.id_produk /*untuk tau detail produknya*/ inner join price_request_item on price_request_item.id_produk = produk.id_produk /*nyaring dengan yang dipesan*/ inner join harga_vendor on harga_vendor.id_request_item = price_request_item.id_request_item /*sambungin ke harga vendor sesuai barang yang dipesan */ inner join contact_person on contact_person.id_cp = harga_vendor.id_cp /*detail contact person */ inner join perusahaan on perusahaan.id_perusahaan = contact_person.id_perusahaan /*untuk tau detail perusahaan*/ where price_request_item.id_request_item = 43 group BY harga_vendor.id_cp
    }
    public function selectVendorItem($where){

        //$this->db->join("contact_person","contact_person.id_cp = harga_vendor.id_cp","inner");
        $this->db->select("harga_vendor.id_perusahaan,perusahaan.nama_perusahaan");
        $this->db->join("perusahaan","harga_vendor.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->join("price_request_item","price_request_item.id_request_item = harga_vendor.id_request_item","inner");
        $this->db->join("produk","produk.id_produk = price_request_item.id_produk","inner");
        $this->db->join("produk_vendor","produk_vendor.id_produk = produk.id_produk","inner");
        $this->db->group_by("perusahaan.id_perusahaan");
        return $this->db->get_where("harga_vendor",$where);
        /*
        select * from harga_vendor inner join perusahaan on harga_vendor.id_perusahaan = perusahaan.id_perusahaan inner join price_request_item on price_request_item.id_request_item = harga_vendor.id_request_item inner join produk on produk.id_produk = price_request_item.id_produk inner join produk_vendor on produk_vendor.id_produk = produk.id_produk where harga_vendor.id_request_item = 42 group by perusahaan.id_perusahaan
        */
    }
    public function countPrice($where){
        $this->db->select("(harga_produk*vendor_price_rate/satuan_harga_produk) as 'total'");
        return $this->db->get_where("harga_vendor",$where);
    }
    
    /* dari sini kebawah, itu yang kepake di sistem setelah review menjelang terakhir*/
    public function getListHargaVendor($where){
        $this->db->join("price_request_item","price_request_item.id_request_item = harga_vendor.id_request_item","inner");
        return $this->db->get_where("harga_vendor",$where);
    }
    public function getListHargaCourier($where){
        $this->db->join("price_request_item","price_request_item.id_request_item = harga_courier.id_request_item","inner");
        return $this->db->get_where("harga_courier",$where);
    }
    public function getListHargaShipping($where){
        $this->db->join("harga_vendor","harga_vendor.id_harga_vendor = harga_shipping.id_harga_vendor","inner");
        $this->db->join("price_request_item","price_request_item.id_request_item = harga_vendor.id_request_item","inner");
        return $this->db->get_where("harga_shipping",$where);
    }
}
?>