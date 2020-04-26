<?php
class M_pdf_quotation extends CI_Model{
    
    function selectQuotation($where){
        return $this->db->get_where("quotation",$where);
    }

    function selectPerusahaan($where){
        return $this->db->query("select * from price_request join quotation on price_request.id_submit_request = quotation.id_request join perusahaan on perusahaan.id_perusahaan = price_request.id_perusahaan WHERE quotation.id_submit_quotation = " . $where['id_submit_quotation']);
    }

    function selectBarang($where){
        return $this->db->query("select * from quotation join quotation_item on quotation.id_submit_quotation = quotation_item.id_submit_quotation WHERE quotation.id_submit_quotation = " . $where['id_submit_quotation']);
    }
}
?>