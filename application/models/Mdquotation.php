<?php
class Mdquotation extends CI_Model{
    public function select($where){
        return $this->db->get_where("quotation",$where);
    }
    public function insert($data){
        $this->db->insert("quotation",$data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
        $this->db->update("quotation",$data,$where);
    }
    public function delete($where){
        $this->db->delete("quotation",$where);
    }
    public function maxId(){
        $this->db->select("max(id_quo) as a");
        $row = $this->db->get("quotation");
        foreach($row->result() as $a){
            if($a->a != ""){
                return $a->a+1;
            }
            else return 1;
        }
    }
    public function select2($data){
        $this->db->join("contact_person","contact_person.id_cp = quotation.id_cp","inner");
        $this->db->join("perusahaan","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->join("price_request","price_request.id_request = quotation.id_request","inner");
        $this->db->join("quotation_item","quotation_item.id_quotation = quotation.id_quo and quotation_item.quo_version = quotation.versi_quo","inner");
        $this->db->group_by("quotation.id_quo,quotation.versi_quo");
        return $this->db->get_where("quotation",$data);
    }
    public function maxVersion($where){
        $this->db->select("max(versi_quo) as a");
        $row = $this->db->get_where("quotation",$where);
        foreach($row->result() as $a){
            return $a->a+1;
        }
    }
    public function selectForOc($data){
        $this->db->join("contact_person","contact_person.id_cp = quotation.id_cp","inner");
        $this->db->join("perusahaan","contact_person.id_perusahaan = perusahaan.id_perusahaan","inner");
        $this->db->join("price_request","price_request.id_request = quotation.id_request","inner");
        $this->db->join("quotation_item","quotation_item.id_quotation = quotation.id_quo and quotation_item.quo_version = quotation.versi_quo","inner");
        $this->db->group_by("quotation.id_quo,quotation.versi_quo");
        $this->db->where("quotation.id_quotation not in (select id_quotation from order_confirmation");
        return $this->db->get_where("quotation",$data);
    }
    /**************************************************************************** */
    public function getListQuotation($where,$field = ""){
        if($field != ""){
            $this->db->select($field);
        }
        $this->db->order_by("id_submit_quotation","DESC");
        return $this->db->get_where("quotation",$where);
    }
    /******************************************************************************* */
    /**
     * function ini dibutuhkan untuk mendapatkan barang di price request dan barang yang sudah ada dalam quotation 
     * masalahnya adalah setelah revisi, semua item kedouble, sehingga dibutuhkan satu function agar tidak kecampur antar versi
     * @params
     * $id_submit_request = untuk tau item originnya apa (mengatasi kesalahan hapus)
     * $id_submit_quotation = untuk tau quotation yang dipilhi apa
     * $field = untuk field yang akan dipilih
     */
    public function getQuotationItem($id_submit_request,$id_submit_quotation,$field){
        $this->db->select($field);
        $this->db->group_start()
            ->where("id_submit_request",$id_submit_request)
            ->where("id_submit_quotation","")
        ->group_end()
        ->or_group_start()
            ->where("id_submit_request",$id_submit_request)
            ->where("id_submit_quotation",$id_submit_quotation)
        ->group_end();

        return $this->db->get("order_item_detail");
    }
    /******** Data Table ********/
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
?>