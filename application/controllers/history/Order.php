<?php

class Order extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdorder_confirmation");
    }
    public function index(){
        $this->session->page = 1;
        if($this->session->id_user == "") redirect("login/welcome");//sudah di cek
        $this->removeFilter();
        redirect("history/order/page/".$this->session->page);
    }
    public function sort(){
        $this->session->order_by = $this->input->post("order_by");
        $this->session->order_direction = $this->input->post("order_direction");
        redirect("history/order/page/".$this->session->page);
    }
    public function search(){
        $search = $this->input->post("search");
        $this->session->search = $search;
        redirect("history/order/page/".$this->session->page);
    }
    public function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/chart-widget/chart-widget-css");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("req/head-close");
        $this->load->view("history/history-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        //$this->load->view("plugin/chart-widget/chart-widget-js");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("history/history-close");
        $this->load->view("req/html-close"); 
    }
    /**
     * ini yang diganti tinggal search, search_print, field, cara cari datanya
     */
    public function page($i){
        /*page data*/
        $this->session->page = $i;
        $limit = 10;
        $offset = 10*($i-1);
        if($i <= 3){
            $data["numbers"] = array(1,2,3,4,5);
            $data["prev"] = 1;
            $data["search"] = 1;
        }
        else{
            for($a = 0; $a<5; $a++){
                $data["numbers"][$a] = $i+$a-2;
                $data["prev"] = 0;
                $data["search"] = 1;
            }
        }
        $data["search"] = array(
            "date_oc_add","no_po_customer","tgl_po_customer","total_oc_price","no_oc","date_quotation_add","total_quotation_price","no_quotation","date_request_add","no_request","nama_perusahaan"
        );
        $data["search_print"] = array(
            "Tanggal Buat oc","no po customer","Tanggal po customer","total Harga oc","no oc","Tanggal Buat quotation","total Harga quotation ","no quotation","Tanggal Buat request","no request","nama perusahaan"
        );
        /*end page data*/

        /*form condition*/
        if($this->session->search != ""){
            $or_like = array(
                "date_oc_add" => $this->session->search,
                "no_po_customer" => $this->session->search,
                "tgl_po_customer" => $this->session->search,
                "total_oc_price" => $this->session->search,
                "no_oc" => $this->session->search,
                "date_quotation_add" => $this->session->search,
                "total_quotation_price" => $this->session->search,
                "no_quotation" => $this->session->search,
                "date_request_add" => $this->session->search,
                "no_request" => $this->session->search,
                "nama_perusahaan" => $this->session->search,
            );
        }
        else{
            $or_like = "";
        }
        if($this->session->order_by != ""){
            $order_by = $this->session->order_by;
        }
        else{
            $order_by = "tgl_po_customer";
        }
        if($this->session->order_direction != ""){
            $direction = $this->session->order_direction;
        }
        else{
            $direction = "DESC";
        }
        /*end form condition*/
        $where = array(
            "status_aktif_oc" => 0
        );
        $field = array(
           "id_submit_oc","date_oc_add","no_po_customer","tgl_po_customer","total_oc_price","no_oc","id_submit_quotation","date_quotation_add","total_quotation_price","no_quotation","id_submit_request","date_request_add","no_request","nama_perusahaan","nama_cp"
        );
        $result = $this->Mdorder_confirmation->getDataTable($where,$field,$or_like,$order_by,$direction,$limit,$offset);
        $data["history"] = $result->result_array();
        for($a = 0; $a<count($data["history"]); $a++){
            $where = array(
                "id_submit_oc" => $data["history"][$a]["id_submit_oc"]
            );
            $field = array(
                "nama_oc_item","final_amount","satuan_oc_item","final_selling_price","nama_quotation_item","item_amount","satuan_quotation_item","selling_price","nama_request_item","jumlah_produk","satuan_request_item"
            );
            $result = selectRow("detail_finished_order_item",$where,$field);
            $data["history"][$a]["items"] = $result->result_array();
            $data["history"][$a]["jumlah_item"] = $result->num_rows();

            $field = array(
                "id_pembayaran","total_pembayaran","no_invoice","id_submit_oc","status_transaksi","total_pembayaran","tgl_bayar","subject_pembayaran","is_lain_lain","flow_transaksi"
            );
            $result = selectRow("list_transaksi_per_oc",$where,$field);
            $data["history"][$a]["transaksi"] = $result->result_array();
            $data["history"][$a]["jumlah_transaksi"] = $result->num_rows();

            
            $where = array(
                "id_submit_oc" => $data["history"][$a]["id_submit_oc"],
            );
            $selisih = getTotal("list_transaksi_per_oc","total_pembayaran",$where);
            
            $where = array(
                "id_submit_oc" => $data["history"][$a]["id_submit_oc"],
                "total_pembayaran < " => 0 
            );
            $keluar = getTotal("list_transaksi_per_oc","total_pembayaran",$where);

            $where = array(
                "id_submit_oc" => $data["history"][$a]["id_submit_oc"],
                "total_pembayaran > " => 0 
            );
            $masuk = getTotal("list_transaksi_per_oc","total_pembayaran",$where);

            $data["history"][$a]["selisih"] = $selisih;
            $data["history"][$a]["masuk"] = $masuk;
            $data["history"][$a]["keluar"] = $keluar;
            if($masuk != 0){
                $data["history"][$a]["margin"] = ($selisih/$masuk)*100;
            }
            else $data["history"][$a]["margin"] = 0;

            $field = array(
                "no_od","date_od_add","delivery_method"  
            );
            $where = array(
                "id_submit_oc" => $data["history"][$a]["id_submit_oc"]
            );
            $result = selectRow("od_detail",$where,$field);
            $data["history"][$a]["od"] = $result->result_array();
            $data["history"][$a]["jumlah_od"] = $result->num_rows();
        }
        /*code_dari_index*/
        $this->req();
        $this->load->view("history/content-open");
        $this->load->view("history/order/category-header");
        $this->load->view("history/order/category-body",$data);
        $this->load->view("history/content-close");
        $this->close();
    }
    public function removeFilter(){
        $this->session->unset_userdata("order_by");
        $this->session->unset_userdata("order_direction");
        $this->session->unset_userdata("search");
        redirect("history/order/page/".$this->session->page);
    }
}
?>