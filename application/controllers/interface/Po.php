<?php
class Po extends CI_Controller{
    public function isExists(){
        $where = array(
            "no_po" => $this->input->post("no_refrence")
        );
        echo json_encode(isExistsInTable("po_core",$where));

    }  
    public function generateNoPO(){
        $maxId = $this->input->post("max_id");
        $id_perusahaan = $this->input->post("id_perusahaan");
        $no_po = "LI-".sprintf("%03d",$maxId)."/PO/".bulanRomawi(date("m"))."/".date("Y")."/".sprintf("%03d",$id_perusahaan);
        echo json_encode($no_po);
    }
}
?>