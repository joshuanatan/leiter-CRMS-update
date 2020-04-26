<?php
class M_pdf_po extends CI_Model{
    
    function selectPo($where){
        return $this->db->get_where("po_core",$where);
    }

    function selectVendor($where){
        return $this->db->query("select * from perusahaan join po_core on po_core.id_supplier = perusahaan.id_perusahaan join contact_person on contact_person.id_cp = po_core.id_cp_supplier where id_submit_po=" . $where['id_submit_po']);
    }

    function selectCust($where){
        return $this->db->query("select * from po_core join order_confirmation on order_confirmation.id_submit_oc=po_core.id_submit_oc join quotation on quotation.id_submit_quotation = order_confirmation.id_submit_quotation join price_request on price_request.id_submit_request = quotation.id_request join perusahaan on price_request.id_perusahaan= perusahaan.id_perusahaan WHERE po_core.id_submit_po=" . $where['id_submit_po']);
    }

    function selectBarang($where){
        return $this->db->query("select * from po_core join po_item on po_core.id_submit_po = po_item.id_submit_po WHERE po_core.id_submit_po = " . $where['id_submit_po']);
    }
    function selectStockPoItem($where){
        $where = array(
            "id_submit_po" => $where["id_submit_po"]
        );
        return $this->db->get_where("po_stock_item_detail",$where);
    }
    function selectShipper($where){
        return $this->db->query("select * from perusahaan join po_core on po_core.id_shipper = perusahaan.id_perusahaan join contact_person on contact_person.id_cp = po_core.id_cp_supplier where id_submit_po=" . $where['id_submit_po']);
    }
}
?>