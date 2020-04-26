<?php
class Mdod_item extends CI_Model{
    public function select($where){
        return $this->db->get_where("od_item", $where);
    }
    public function insert($data){
        $this->db->insert("od_item",$data);
    }
    public function delete($where){
        $this->db->delete("od_item",$where);
    }
    /************************************************** */
    public function getOdItem($where,$field,$id_submit_oc,$id_submit_od){
        $this->db->select($field);
        $this->db->where("od_item_detail.id_submit_oc",$id_submit_oc);
        $this->db->group_start();
        $this->db->where("id_submit_od",$id_submit_od);
        $this->db->or_where("id_submit_od is null",NULL,FALSE);
        $this->db->group_end();
        return $this->db->get_where("od_item_detail",$where);
    }
}

?>