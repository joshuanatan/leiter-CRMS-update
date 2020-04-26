<?php
class Mdprice_request extends CI_Model{
    public function select($where){
        return $this->db->get_where("price_request",$where);
    }
    public function insert($data){
        $this->db->insert("price_request",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("price_request",$data,$where);
    }
    public function delete($where){
        $this->db->delete("price_request",$where);
    }
    public function maxId(){
        $this->db->select("max(id_request) as a");
        $row = $this->db->get("price_request");
        foreach($row->result() as $a){
            if($a->a != ""){
                return $a->a+1;
            }
            else return 1;
        }
    }
    public function select2($data){
        $this->db->select("*,count(id_request_item) as 'a'");
        $this->db->join("price_request_item","price_request_item.id_request = price_request.id_request","inner");
        $this->db->join("contact_person","contact_person.id_cp = price_request.id_cp","inner");
        $this->db->join("perusahaan","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->join("user","user.id_user = price_request.id_user_add","inner");
        $this->db->where("price_request_item.status_request_item",0);
        $this->db->where("price_request_item.id_produk in (select id_produk from produk_vendor)",NULL,FALSE);
        $this->db->group_by("price_request_item.id_request");
        return $this->db->get_where("price_request",$data);
    }
    /* dari sini kebawah, itu yang kepake di sistem setelah review menjelang terakhir*/
    public function getListPriceRequest($where){
        $this->db->where("status_aktif_request",0); /*yang aktif*/
        $this->db->order_by("date_request_add","DESC");
        return $this->db->get_where("price_request",$where); /*bisa jadi di pilih per segment atau yang tidak permanen dsb*/
    }
    /*********** Data Table ***********/
    public function getDataTable($where,$field,$or_like = "",$order_by,$direction,$limit,$offset,$group_by){
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->select($field);

        $this->db->group_start();
        $this->db->where($where);
        $this->db->group_end();
        if($or_like != ""){
            $this->db->group_start();
            $this->db->or_like($or_like);
            $this->db->group_end();
        }
        $this->db->group_by($group_by);
        $this->db->order_by($order_by,$direction);
        return $this->db->get("order_detail");
    }
}
?>