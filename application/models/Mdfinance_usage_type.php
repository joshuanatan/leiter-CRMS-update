<?php
class Mdfinance_usage_type extends CI_Model{
    public function select($data){
        return $this->db->get_where("finance_usage_type",$data);
    }
    public function insert($data){
        $this->db->insert("finance_usage_type",$data);
    }
    public function update($data,$where){
        $this->db->update("finance_usage_type",$data,$where);
    }
    public function delete($where){
        $this->db->delete("finance_usage_type",$where);
    }
    public function selectType($where){
        $this->db->group_by("type_finance_usage_type");
        return $this->db->get_where("finance_usage_type",$where);
    }
}
?>