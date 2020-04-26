<?php
class Mdpo_core extends CI_Model{
    public function select($where){
        return $this->db->get_where("po_core",$where);
    }
    public function update(){

    }
    public function delete(){
        
    }
    public function insert($data){
        $this->db->insert("po_core",$data);
    }
    public function maxId(){
        $this->db->select("max(id_po) as maxId");
        $row = $this->db->get("po_core");
        foreach($row->result() as $a){
            if($a->maxId != ""){
                return $a->maxId+1;
            }
            else return 1;
        }
    }
    /**************************************************************** */
    public function getListPo($where){
        $this->db->order_by("id_submit_po","DESC");
        return $this->db->get_where("po_core",$where);
    }
}
?>