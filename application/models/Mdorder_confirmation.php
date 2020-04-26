<?php
class Mdorder_confirmation extends CI_Model{

    var $table = 'tbl_user'; //nama tabel dari database
    var $column_order = array(null, 'user_nama','user_email','user_alamat'); //field yang ada di table user
    var $column_search = array('user_nama','user_email','user_alamat'); //field yang diizin untuk pencarian 
    var $order = array('user_id' => 'asc'); // default order 

    public function select($where){
        $this->db->join("quotation","quotation.id_quo = order_confirmation.id_quotation and quotation.versi_quo = order_confirmation.versi_quotation","inner");
        $this->db->join("contact_person","contact_person.id_cp = quotation.id_cp","inner");
        $this->db->join("perusahaan","perusahaan.id_perusahaan = contact_person.id_perusahaan","inner");
        return $this->db->get_where("order_confirmation",$where);
    }
    public function insert($data){
        $this->db->insert("order_confirmation",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("order_confirmation",$data,$where);
    }
    public function delete($where){
        $this->db->delete("order_confirmation",$where);
    }
    public function maxId(){
        $this->db->select("max(id_oc) as a");
        $row = $this->db->get("order_confirmation");
        foreach($row->result() as $a){
            if($a->a != ""){
                return $a->a+1;
            }
            else return 1;
        }
    }
    /************************************************************** */
    public function getListOc($where){
        $this->db->order_by("id_submit_oc","DESC");
        return $this->db->get_where("order_confirmation",$where);
    }
    public function getListOcForOd($where,$field){
        $this->db->select($field);
        $this->db->group_start();

            $this->db->group_start();
                $this->db->where("is_ada_transaksi",0);
                $this->db->where("status_bayar",0);
            $this->db->group_end();

            $this->db->or_where("is_ada_transaksi",1);
        $this->db->group_end();

        $this->db->group_start();
            
            /*pelunasan sebelum od [harus lunas]*/
            $this->db->group_start();
                $this->db->where("is_ada_transaksi2",0);
                $this->db->where("trigger_pembayaran2",1);
                $this->db->where("status_bayar2",0);
            $this->db->group_end();

            /*pelunasan setelah od*/
            $this->db->or_group_start();
                $this->db->where("is_ada_transaksi2", 0 );
                $this->db->where("trigger_pembayaran2", 2);
            $this->db->group_end();

            /*tidak ada pelunasan, semua lunas di awal*/
            $this->db->or_group_start();
                $this->db->where("is_ada_transaksi2", 1);
            $this->db->group_end();

        $this->db->group_end();
        return $this->db->get_where("metode_pembayaran_oc",$where);
    }
    /************************************************************* */
    
    /**
     * dipake untuk insert ke order confirmation serta table pendukungnya 
     * $oc = data oc
     * $oc_item = data item oc
     * $oc_pembayaran = data metode pembayaran oc
     */
    public function createOrderConfirmation($oc,$oc_item,$oc_pembayaran){
        $this->db->trans_begin();
        $this->db->insert("order_confirmation",$oc);
        $this->db->insert_batch("order_confirmation_item",$oc_item);
        $this->db->insert("order_confirmation_metode_pembayaran",$oc_pembayaran);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $where = array(
                "id_submit_quotation" => $this->session->id_submit_quotation,
            );
            $data = array(
                "status_quotation" => 3 /*yang udah create oc, ditandain*/
            );
            updateRow("quotation",$data,$where);
            $this->db->trans_commit();
        }
    }
    /******** Data Table ****** */
    public function getDataTable($where,$field,$or_like = "",$order_by,$direction,$limit,$offset){
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->select($field);

        $this->db->group_start();
        $this->db->where($where);
        $this->db->group_end();
        if($or_like != ""){
            $this->db->group_start();
            $this->db->or_like($or_like);
            $this->db->group_end();
        }
        $this->db->order_by($order_by,$direction);
        return $this->db->get("order_detail");
    }
}