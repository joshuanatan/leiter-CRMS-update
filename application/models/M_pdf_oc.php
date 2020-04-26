<?php
class M_pdf_oc extends CI_Model{
    
    function selectOc($where){
        return $this->db->query("SELECT * FROM order_confirmation join quotation ON order_confirmation.id_submit_quotation=quotation.id_submit_quotation WHERE order_confirmation.id_submit_oc=" .$where['id_submit_oc']);
    }

    function selectPerusahaan($where){
        return $this->db->query("select * from order_confirmation join quotation on quotation.id_submit_quotation = order_confirmation.id_submit_quotation join price_request on price_request.id_submit_request = quotation.id_request join perusahaan on perusahaan.id_perusahaan = price_request.id_perusahaan WHERE order_confirmation.id_submit_oc=" . $where['id_submit_oc']);
    }

    function selectBarang($where){
        return $this->db->query("select * from order_confirmation_item WHERE order_confirmation_item.id_submit_oc=". $where['id_submit_oc']);
    }

    function selectMetodeBayar($where){
        return $this->db->get_where("order_confirmation_metode_pembayaran",$where);
    }
}
?>