<?php
class M_pdf_od extends CI_Model{
    
    function selectOd($where){
        return $this->db->get_where("od_core",$where);
    }

    function selectPerusahaan($where){
        return $this->db->query("select * from od_core join order_confirmation on od_core.id_submit_oc = order_confirmation.id_submit_oc join quotation on quotation.id_submit_quotation = order_confirmation.id_submit_quotation join price_request on price_request.id_submit_request = quotation.id_request join perusahaan on perusahaan.id_perusahaan = price_request.id_perusahaan WHERE od_core.id_submit_od=" . $where['id_submit_od']);
    }

    function selectBarang($where){
        return $this->db->query("select * from od_item join order_confirmation_item on od_item.id_oc_item =  order_confirmation_item.id_oc_item WHERE od_item.id_submit_od=". $where['id_submit_od']);
    }

    function selectNoPoCus($where){
        return $this->db->query("select * from od_core join order_confirmation on od_core.id_submit_oc = order_confirmation.id_submit_oc WHERE od_core.id_submit_od=" . $where['id_submit_od']);
    }
}
?>