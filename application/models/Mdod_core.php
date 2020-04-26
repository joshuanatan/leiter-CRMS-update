<?php
class Mdod_core extends CI_Model{
    public function select($where){
        return $this->db->get_where("od_core", $where);
    }
    public function insert($data){
        $this->db->insert("od_core",$data);
    }
    public function delete($where){
        $this->db->delete("od_core",$where);
    }
    /*************** */
    public function getListOd($where){
        $this->db->order_by("id_submit_od","DESC");
        return $this->db->get_where("od_core",$where);
    }
}

?>