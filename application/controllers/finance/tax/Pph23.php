<?php
class Pph23 extends CI_Controller{
    public function __constrcut(){
        parent::__construct();
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
            "jenis_pajak" => "PPH",
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
        $this->load->view("finance/tax/pph23/category-header");
        $this->load->view("finance/tax/pph23/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function report(){
        $bulan_pajak = $this->input->post("bulan_pajak");
        $tahun_pajak = $this->input->post("tahun_pajak");
        redirect("finance/tax/pph23/detail/".$bulan_pajak."/".$tahun_pajak);
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
            "jenis_pajak" => "PPH",
            "status_aktif_pajak" => 0,
            "bulan_pajak" => $bulan_pajak,
            "tahun_pajak" => $tahun_pajak
        );
        $field = array(
            "id_tax","jumlah_pajak","tipe_pajak","jenis_pajak","id_refrensi","status_aktif_pajak","is_pib","attachment","no_faktur_pajak","bulan_pajak","tahun_pajak"
        );
        $result = selectRow("tax",$where,$field);
        $data["tax"] = $result->result_array();
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/tax/pph23/category-header");
        $this->load->view("finance/tax/pph23/detail-pph",$data);
        $this->load->view("finance/content-close");
        $this->close();
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
        redirect("finance/tax/pph23");
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
        redirect("finance/tax/pph23/detail/".$this->input->post("bulan_pajak")."/".$this->input->post("tahun_pajak"));
    }
    public function excel($bulan_pajak,$tahun_pajak){
        $where = array(
            "jenis_pajak" => "PPH",
            "status_aktif_pajak" => 0,
            "bulan_pajak" => $bulan_pajak,
            "tahun_pajak" => $tahun_pajak
        );
        $field = array(
            "no_faktur_pajak","jumlah_pajak","id_refrensi"
        );
        $result = selectRow("tax",$where,$field);
        $data["tax"] = $result->result_array();
        $data["bulan_pajak"] = $bulan_pajak;
        $data["tahun_pajak"] = $tahun_pajak;
        $this->load->view("finance/tax/pph23/excel-output",$data);
    }
}

?>