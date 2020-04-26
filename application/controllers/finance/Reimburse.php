<?php
class Reimburse extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    private function req(){
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
        $this->load->view("finance/receivable/js/request-ajax");
        $this->load->view("finance/finance-close");
        $this->load->view("req/html-close");
    }
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome"); //sudah di cek //untuk yang di finance
        $where = array(
            "reimburse" => array(
                "status_aktif_reimburse" => 0,
            )
        );
        $field = array(
            "reimburse" => array(
                "id_reimburse","subject_reimburse","nominal_reimburse","attachment","notes","id_user_add","tgl_reimburse_add","status_paid",
            )
        );
        $print = array(
            "reimburse" => array(
                "id_reimburse","subject_reimburse","nominal_reimburse","attachment","notes","id_user_add","tgl_reimburse_add","status_paid",
            )
        );
        $result["reimburse"] = selectRow("reimburse",$where["reimburse"]);
        $data["reimburse"] = foreachMultipleResult($result["reimburse"],$field["reimburse"],$print["reimburse"]);
        for($a = 0; $a<count($data["reimburse"]);$a++){
            $data["reimburse"][$a]["nama_user"] = get1Value("user","nama_user",array("id_user" => $data["reimburse"][$a]["id_user_add"]));

            if($data["reimburse"][$a]["status_paid"] == 0){
                /*kalau sudah dibayar*/
                /*load data dari pembayaran untuk reimburse ini */
                $result["payment_data"] = selectRow("pembayaran",array("id_refrensi" => "RMBS-".$data["reimburse"][$a]["id_reimburse"]));
                
                $field["payment_data"] = array(
                    "id_pembayaran","subject_pembayaran","tgl_bayar","attachment","notes_pembayaran","nominal_pembayaran","metode_pembayaran"
                );
                $print["payment_data"] = array(
                    "id_pembayaran","subject_pembayaran","tgl_bayar","attachment","notes_pembayaran","nominal_pembayaran","metode_pembayaran"
                );
                /*end data pembayaran*/
                /*masukin ke variable payment data*/
                $data["reimburse"][$a]["payment_data"] = foreachResult($result["payment_data"],$field["payment_data"],$print["payment_data"]);
            }

        }
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/reimburse/category-header");
        $this->load->view("finance/reimburse/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function request(){
        if($this->session->id_user == "") redirect("login/welcome"); //sudah di cek //untuk disetiap orang
        $where = array(
            "reimburse" => array(
                "id_user_add" => $this->session->id_user,
                "status_aktif_reimburse" => 0
            )
        );
        $field = array(
            "reimburse" => array(
                "id_reimburse","subject_reimburse","nominal_reimburse","attachment","notes","id_user_add","tgl_reimburse_add","status_paid",
            )
        );
        $print = array(
            "reimburse" => array(
                "id_reimburse","subject_reimburse","nominal_reimburse","attachment","notes","id_user_add","tgl_reimburse_add","status_paid",
            )
        );
        $result["reimburse"] = selectRow("reimburse",$where["reimburse"]);
        $data["reimburse"] = foreachMultipleResult($result["reimburse"],$field["reimburse"],$print["reimburse"]);
        for($a = 0; $a<count($data["reimburse"]);$a++){
            $data["reimburse"][$a]["nama_user"] = get1Value("user","nama_user",array("id_user" => $data["reimburse"][$a]["id_user_add"]));

            if($data["reimburse"][$a]["status_paid"] == 0){
                /*kalau sudah dibayar*/
                /*load data dari pembayaran untuk reimburse ini */
                $result["payment_data"] = selectRow("pembayaran",array("id_refrensi" => "RMBS-".$data["reimburse"][$a]["id_reimburse"]));
                
                $field["payment_data"] = array(
                    "id_pembayaran","subject_pembayaran","tgl_bayar","attachment","notes_pembayaran","nominal_pembayaran","metode_pembayaran"
                );
                $print["payment_data"] = array(
                    "id_pembayaran","subject_pembayaran","tgl_bayar","attachment","notes_pembayaran","nominal_pembayaran","metode_pembayaran"
                );
                /*end data pembayaran*/
                /*masukin ke variable payment data*/
                $data["reimburse"][$a]["payment_data"] = foreachResult($result["payment_data"],$field["payment_data"],$print["payment_data"]);
            }

        }
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/reimburse/category-header");
        $this->load->view("finance/reimburse/reimburse-request",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function insert(){ //sudah di cek
        $config["upload_path"] = "./assets/dokumen/reimburse/";
        $config["allowed_types"] = "jpg|png|jpeg|gif|pdf";
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $dataFile = $this->upload->data();
        }
        else{
            $dataFile = array("file_name" => "-");
        }
        $data = array(
            "subject_reimburse" =>$this->input->post("subject"),
            "nominal_reimburse" =>splitterMoney($this->input->post("amount"),","),
            "attachment" =>$dataFile["file_name"],
            "notes" => $this->input->post("notes"),
            "id_user_add" => $this->session->id_user,
            "tgl_reimburse_add" => date("Y-m-d"),
        );
        insertRow("reimburse",$data);
        redirect("finance/reimburse/request");
    }
    public function edit($id_reimburse){ //sudah di cek
        /*kalau ngedit yang bentuknya menunggu pelunasan, gaperlu ganti yang di cashflow & pembayaran*/
        $where = array(
            "id_reimburse" => $id_reimburse
        );
        $config["upload_path"] = "./assets/dokumen/reimburse/";
        $config["allowed_types"] = "jpg|png|jpeg|gif|pdf";
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment_edit")){
            $dataFile = $this->upload->data();
            $data = array(
                "subject_reimburse" =>$this->input->post("subject_edit"),
                "nominal_reimburse" =>splitterMoney($this->input->post("amount_edit"),","),
                "attachment" =>$dataFile["file_name"],
                "notes" => $this->input->post("notes_edit"),
                "id_user_add" => $this->session->id_user,
                "tgl_reimburse_add" => date("Y-m-d"),
            );
            updateRow("reimburse",$data,$where);
        }
        else{
            $data = array(
                "subject_reimburse" =>$this->input->post("subject_edit"),
                "nominal_reimburse" =>splitterMoney($this->input->post("amount_edit"),","),
                "notes" => $this->input->post("notes_edit"),
                "id_user_add" => $this->session->id_user,
                "tgl_reimburse_add" => date("Y-m-d"),
            );
            updateRow("reimburse",$data,$where);
        }
        redirect("finance/reimburse/request");
    }
    public function reject($id_reimburse){ //sudah di cek
        $where = array(
            "id_reimburse" => $id_reimburse
        );
        $data = array(
            "status_paid" => 2
        );
        updateRow("reimburse",$data,$where);
        redirect("finance/reimburse");
    }
    public function remove($id_reimburse){ //sudah di cek
        $where = array(
            "id_reimburse" => $id_reimburse
        );
        $data = array(
            "status_aktif_reimburse" => 1
        );
        updateRow("reimburse",$data,$where);
        redirect("finance/reimburse/request");
    }
    public function pay($id_reimburse){ //sudah di cek
        $where = array(
            "id_reimburse" => $id_reimburse
        );
        $data = array(
            "status_paid" => 0
        );
        updateRow("reimburse",$data,$where);
        /*update ke pembayaran*/
        $config["upload_path"] = "./assets/dokumen/buktibayar/";
        $config["allowed_types"] = "gif|jpg|jpeg|pdf|png";
        $this->load->library("upload",$config);
        $fileData = array();
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData["file_name"] = "-";
        }
        $data = array(
            "id_refrensi" => "RMBS-".$id_reimburse,
            "subject_pembayaran" => $this->input->post("subject_pembayaran"),
            "tgl_bayar" => $this->input->post("tgl_bayar"),
            "attachment" =>  $fileData["file_name"],
            "notes_pembayaran" =>  $this->input->post("notes_pembayaran"),
            "nominal_pembayaran" =>  splitterMoney($this->input->post("nominal_pembayaran"),","),
            "kurs_pembayaran" =>  1,
            "mata_uang_pembayaran" => "IDR",
            "total_pembayaran" => splitterMoney($this->input->post("nominal_pembayaran"),","),
            "metode_pembayaran" => $this->input->post("metode_pembayaran"),
            "jenis_pembayaran" => "KELUAR",
            "kategori_pembayaran" => 3
        );
        insertRow("pembayaran",$data);
        redirect("finance/reimburse");
    }
}

?>