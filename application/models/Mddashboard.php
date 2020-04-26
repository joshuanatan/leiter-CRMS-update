<?php
class Mddashboard extends CI_Model{
    public function select($data){
        $this->db->group_by("nama_satuan");
        return $this->db->get_where("satuan",$data);
    }

    public function getSalesMonthly($field,$where,$tahun,$durasi){
        $this->db->select($field);
        $this->db->where("tahun_invoice >=",$tahun-$durasi-1); /*3 thun termasuk yang kali ini*/
        return $this->db->get_where("sales_monthly",$where);
    }
    public function getJumlahPo($field,$where,$tahun,$durasi){
        $this->db->select($field);
        $this->db->where("tahun_oc >=",$tahun-$durasi-1); /*3 thun termasuk yang kali ini*/
        $this->db->group_by(array("bulan_oc","tahun_oc"));
        return $this->db->get_where("order_detail",$where);
    }
    public function getCustomerOrder($tahun){
        /*terpaksa pake query karena ga ada ci active record untuk union*/
        $query = "
        select sum(total_oc_price) as total_oc ,nama_perusahaan,tahun_oc from order_detail 
        where order_detail.tahun_oc = ".($tahun-0)."
        group by id_perusahaan 
        union
        select sum(total_oc_price) as total_oc ,nama_perusahaan,tahun_oc from order_detail 
        where order_detail.tahun_oc = ".($tahun-1)."
        group by id_perusahaan 
        union
        select sum(total_oc_price) as total_oc ,nama_perusahaan,tahun_oc from order_detail 
        where order_detail.tahun_oc = ".($tahun-2)."
        group by id_perusahaan 
        order by total_oc DESC";
        return $this->db->query($query,FALSE,NULL);
    }
}
?>