<?php 
class Mdmargin_calculation extends CI_Model{
    public function selectTransaksiOc($where){
        return $this->db->get_where("pembayaran_tagihan",$where);
    }
}
?>