<?php
class Mdorder_data extends CI_Model{
    
    public function getListInvoice($field,$where,$limit){
        $this->db->select($field);
        $this->db->order_by("id_submit_oc","DESC");
        $this->db->limit($limit["limit"],$limit["offset"]);
        return $this->db->get_where("order_detail",$where);
    }
    public function getTotalData($where){
        $this->db->select("count(id_submit_oc) as total_item");
        return $this->db->get_where("order_detail",$where);
    }
}
?>