<?php
class Ppn extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/card/card-css");
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
        $data = array(
            "bulan" => array(
                "01" => "JANUARI",
                "02" => "FEBRUARI",
                "03" => "MARET",
                "04" => "APRIL",
                "05" => "MEI",
                "06" => "JUNI",
                "07" => "JULI",
                "08" => "AGUSTUS",
                "09" => "SEPTEMBER",
                "10" => "OKTOBER",
                "11" => "NOVEMBER",
                "12" => "DESEMBER"
            ),
            "tahun" => array(
                date("Y")
            )
        );
        $where = array(
            "jenis_pajak" => "PPN",
            "is_pib" => 1,
            "no_faktur_pajak" => null
        );
        $field = array(
            "id_tax","jumlah_pajak","id_refrensi"
        );
        $result = selectRow("tax",$where,$field);
        $data["tax"] = $result->result_array();
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/tax/ppn/category-header");
        $this->load->view("finance/tax/ppn/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function updateFaktur(){
        $where = array(
            "id_tax" => $this->input->post("id_tax")
        );
        $config["upload_path"] = "./assets/dokumen/ppn/";
        $config["allowed_types"] = "png|jpg|jpeg|pdf|gif";
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "no_faktur_pajak" => $this->input->post("no_faktur_pajak"),
                "attachment" => $fileData["file_name"],
                "bulan_pajak" => $this->input->post("bulan_pajak"),
                "tahun_pajak" => $this->input->post("tahun_pajak")
            );
        }
        else{
            $data = array(
                "no_faktur_pajak" => $this->input->post("no_faktur_pajak"),
                "bulan_pajak" => $this->input->post("bulan_pajak"),
                "tahun_pajak" => $this->input->post("tahun_pajak")
            );
        }
        updateRow("tax",$data,$where);
        redirect("finance/tax/ppn/detail/".$this->input->post("bulan_pajak")."/".$this->input->post("tahun_pajak"));
    }
    public function insertFaktur(){
        $where = array(
            "id_tax" => $this->input->post("id_tax")
        );  
        $config["upload_path"] = "./assets/dokumen/ppn/";
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
        $split_tgl = explode("-",$this->input->post("tgl_input_faktur"));
        $data = array(
            "bulan_pajak" => $split_tgl[1],
            "tahun_pajak" => $split_tgl[0],
            "tgl_input_faktur" => $this->input->post("tgl_input_faktur"),
            "no_faktur_pajak" => $this->input->post("no_faktur_pajak"),
            "attachment" => $fileData["file_name"]
        );
        updateRow("tax",$data,$where);
        redirect("finance/tax/ppn");
    }
    public function report(){
        $bulan_pajak = $this->input->post("bulan_pajak");
        $tahun_pajak = $this->input->post("tahun_pajak");
        redirect("finance/tax/ppn/detail/".$bulan_pajak."/".$tahun_pajak);
    }
    public function detail($bulan_pajak,$tahun_pajak){
        $data = array(
            "bulan" => array(
                "01" => "JANUARI",
                "02" => "FEBRUARI",
                "03" => "MARET",
                "04" => "APRIL",
                "05" => "MEI",
                "06" => "JUNI",
                "07" => "JULI",
                "08" => "AGUSTUS",
                "09" => "SEPTEMBER",
                "10" => "OKTOBER",
                "11" => "NOVEMBER",
                "12" => "DESEMBER"
            ),
            "tahun" => array(
                date("Y")
            )
        );
        $where = array(
            "bulan_pajak" => $bulan_pajak,
            "tahun_pajak" => $tahun_pajak,
            "jenis_pajak" => "PPN",
        );
        $field = array(
            "id_tax","jumlah_pajak","tipe_pajak","jenis_pajak","id_refrensi","status_aktif_pajak","is_pib","attachment","no_faktur_pajak","tahun_pajak","bulan_pajak"
        );
        $result = selectRow("final_tax",$where,$field);
        $data["tax"] = $result->result_array();
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/tax/ppn/category-header");
        $this->load->view("finance/tax/ppn/detail-ppn",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
}
?>