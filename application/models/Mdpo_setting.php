<?php
class MdPo_setting extends CI_Model{
    public function select($where){
        return $this->db->get_where("po_setting",$where);
    }
    public function update(){

    }
    public function delete(){
        
    }
    public function insert($data){
        $this->db->insert("po_setting",$data);
    }
    public function maxId(){
        $this->db->select("max(id_po_setting) as maxId");
        $row = $this->db->get("po_setting");
        foreach($row->result() as $a){
            if($a->maxId != ""){
                return $a->maxId+1;
            }
            else return 1;
        }
    }
}
?>