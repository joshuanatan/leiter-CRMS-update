<?php
class Othercashflow extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("finance/finance-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("finance/finance-close");
        $this->load->view("req/html-close"); 
    }
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome");
        $this->page(1);
    }
    public function page($page){
        $where = array(
            "status_type" => 0
        );
        $field = array(
            "id_type","name_type"
        );
        $result = selectRow("finance_usage_type",$where,$field);
        $data["expanses_type"] = $result->result_array();

        $where = array(
            "status_aktif_cashflow" => 0
        );
        $field = array(
            "id_submit_tagihan_other","subject_tagihan","name_type","tanggal_pembayaran","nominal_tagihan","attachment","jenis_pembayaran","notes","nama_user","tgl_input_transaksi","id_type"
        );
        $limit = 10;
        $offset = ($page-1)*10;
        $result = selectRow("other_cashflow_detail",$where,$field,$limit,$offset);
        $data["cashflow"] = $result->result_array();

        $data["page"] = $page;
        $data["count_page"] = 5; 
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/other_cashflow/category-header");
        $this->load->view("finance/other_cashflow/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function insert(){
        if($this->session->id_user == "") redirect("welcome");
        $check_data = array(
            "subject_tagihan" => $this->input->post("subject_tagihan"),
            "id_type" => $this->input->post("id_type"),
            "nominal_tagihan" =>$this->input->post("nominal_tagihan"),
            "tanggal_pembayaran" => $this->input->post("tanggal_pembayaran"),
        );
        if(in_array("",$check_data)){
            $this->session->set_flashdata("invalid","Terdapat form yang kosong");
            $report = "Your Input Before: ";
            foreach($check_data as $key => $value){
                $report .= $key." = ".$value."<br/>";
            }
            $this->session->set_flashdata("report",$report);
            redirect("finance/othercashflow");
        }
        $config["upload_path"] = "./assets/dokumen/othercashflow/";
        $config["allowed_types"] = "png|jpg|jpeg|pdf|gif";
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData = array(
                "file_name" => "-"
            );
        }
        $money = splitterMoney($this->input->post("nominal_tagihan"),",");
        $data = array(
            "id_submit_tagihan_other" => getMaxId("other_cashflow","id_submit_tagihan_other",array()),
            "subject_tagihan" => $this->input->post("subject_tagihan"),
            "id_type" => $this->input->post("id_type"),
            "nominal_tagihan" => $money,
            "tanggal_pembayaran" => $this->input->post("tanggal_pembayaran"),
            "id_user_add" => $this->session->id_user,
            "attachment" => $fileData["file_name"],
            "notes" => $this->input->post("notes"),
            "status_aktif_cashflow" => '0',
            "tgl_input_transaksi" => date("Y-m-d"),
            "jenis_pembayaran" => $this->input->post("jenis_pembayaran")
        );
        insertRow("other_cashflow",$data);
        redirect("finance/othercashflow");
    }
    public function remove($id_submit_tagihan_other){
        $where = array(
            "id_submit_tagihan_other" => $id_submit_tagihan_other
        );
        $data = array(
            "status_aktif_cashflow" => 1
        );
        updateRow("other_cashflow",$data,$where);
        redirect("finance/othercashflow");
    }
    public function update(){
        $where = array(
            "id_submit_tagihan_other" => $this->input->post("id_submit_tagihan_other")
        );
        $config["upload_path"] = "./assets/dokumen/othercashflow/";
        $config["allowed_types"] = "png|jpg|jpeg|pdf|gif";
        $this->load->library("upload",$config);
        
        $money = splitterMoney($this->input->post("nominal_tagihan"),",");
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "subject_tagihan" => $this->input->post("subject_tagihan"),
                "id_type" => $this->input->post("id_type"),
                "nominal_tagihan" => $money,
                "tanggal_pembayaran" => $this->input->post("tanggal_pembayaran"),
                "id_user_add" => $this->session->id_user,
                "attachment" => $fileData["file_name"],
                "notes" => $this->input->post("notes"),
                "status_aktif_cashflow" => '0',
                "tgl_input_transaksi" => date("Y-m-d"),
                "jenis_pembayaran" => $this->input->post("jenis_pembayaran")
            );
        }
        else{
            $data = array(
                "subject_tagihan" => $this->input->post("subject_tagihan"),
                "id_type" => $this->input->post("id_type"),
                "nominal_tagihan" => $money,
                "tanggal_pembayaran" => $this->input->post("tanggal_pembayaran"),
                "id_user_add" => $this->session->id_user,
                "notes" => $this->input->post("notes"),
                "status_aktif_cashflow" => '0',
                "tgl_input_transaksi" => date("Y-m-d"),
                "jenis_pembayaran" => $this->input->post("jenis_pembayaran")
            );
        }
        updateRow("other_cashflow",$data,$where);
        redirect("finance/othercashflow");
    }

}

?>