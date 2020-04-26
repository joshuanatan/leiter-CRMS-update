<?php
class Mdorder_confirmation_item extends CI_Model{
    public function getListOrderConfirmationItem($where){
        return $this->db->get_where("order_confirmation_item",$where);
    }
}