<?php
class Payable extends CI_Controller{
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
        $this->load->view("finance/payable/js/form-js");
        $this->load->view("finance/finance-close");
        $this->load->view("req/html-close"); 
    }
    public function index(){ 
        if($this->session->id_user == "") redirect("login/welcome");//sudah di cek
        $where["tagihan"] = array(
            "tagihan.id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_payable")) == 0){
            $where["tagihan"] = array(
                "status_aktif_invoice" => 0,
                "tagihan.id_user_add" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_payable")) == 0){
            $where["tagihan"] = array(
                "status_aktif_invoice" => 0
            );
        }
        $field["tagihan"] = array(
            "id_tagihan","no_invoice","no_refrence","peruntukan_tagihan","total","rekening_pembayaran","status_lunas","notes_tagihan","attachment","mata_uang","dateline_invoice","ppn","pph"   
        );
        $result = selectRow("tagihan",$where["tagihan"],$field["tagihan"]);
        $data["tagihan"] = $result->result_array();
        for($a = 0; $a<count($data["tagihan"]);$a++){
            $id_supplier = "";
            switch($data["tagihan"][$a]["peruntukan_tagihan"]){
                case "SUPPLIER":
                $id_supplier = get1Value("po_core","id_supplier",array("no_po" => $data["tagihan"][$a]["no_refrence"]));
                break;
                case "SHIPPER":
                $id_supplier = get1Value("po_core","id_shipper",array("no_po" => $data["tagihan"][$a]["no_refrence"]));
                break;
                case "COURIER":
                $id_supplier = get1Value("od_core","id_courier",array("no_od" => $data["tagihan"][$a]["no_refrence"]));
            }
            $data["tagihan"][$a]["nama_target"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan"=>$id_supplier));
            /*cek pembayaran*/
            if($data["tagihan"][$a]["status_lunas"] == 0){
                $where["pembayaran"] = array(
                    "id_refrensi" => $data["tagihan"][$a]["id_tagihan"]
                );
                $field["pembayaran"] = array(
                    "id_pembayaran","subject_pembayaran","tgl_bayar","attachment","notes_pembayaran","nominal_pembayaran","kurs_pembayaran","mata_uang_pembayaran","total_pembayaran","metode_pembayaran"
                );
                $result = selectRow("pembayaran",$where["pembayaran"],$field["pembayaran"]);
                $data["tagihan"][$a]["pembayaran"] = $result->result_array();
                
            }
        }
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/payable/category-header");
        $this->load->view("finance/payable/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function insert(){ //sudah di cek
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/payable/category-header");
        $this->load->view("finance/payable/add-invoice");
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function edit($id_tagihan){ //sudah di cek
        
        $where = array(
            "tagihan" => array(
                "id_tagihan" => $id_tagihan
            )
        );
        $field = array(
            "tagihan" => array(
                "id_tagihan","no_invoice","no_refrence","peruntukan_tagihan","rekening_pembayaran","subtotal","is_ppn","is_pph","discount","total","mata_uang","notes_tagihan","attachment","dateline_invoice","ppn","pph"
            )
        );
        $print = array(
            "tagihan" => array(
                "id_tagihan","no_invoice","no_refrence","peruntukan_tagihan","rekening_pembayaran","subtotal","is_ppn","is_pph","discount","total","mata_uang","notes_tagihan","attachment","dateline_invoice","ppn","pph"
            )
        );
        $result["tagihan"] = selectRow("tagihan",$where["tagihan"]);
        $data["tagihan"] = foreachResult($result["tagihan"],$field["tagihan"],$print["tagihan"]);
        
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/payable/category-header");
        $this->load->view("finance/payable/edit-invoice",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function insertinvoice(){ //sudah di cek
        /*sudah jalan */
        /*masukin data primarynya*/
        $check_ppn = $this->input->post("is_ppn");
        if(isChecked($check_ppn)) $is_ppn = 0; else $is_ppn = 1;
        $check_pph = $this->input->post("is_pph");
        if(isChecked($check_pph)) $is_pph = 0; else $is_pph = 1;

        $config["upload_path"] = './assets/dokumen/invoice/';
        $config["allowed_types"] = 'pdf|docx|doc|xls|xlsx|png|jpg|jpeg';
        $this->load->library("upload",$config);
        $doc_data = array();
        if($this->upload->do_upload("attachment")){
            $doc_data = $this->upload->data();
        }
        else $doc_data = array("file_name" => "-");
        $data = array(
            "no_invoice" => $this->input->post("no_invoice"),
            "no_refrence" => $this->input->post("no_refrence"),
            "peruntukan_tagihan" => $this->input->post("peruntukan_tagihan"),
            "rekening_pembayaran" => $this->input->post("rekening"),
            "subtotal" => splitterMoney($this->input->post("subtotal"),","),
            "is_ppn" =>  $is_ppn,
            "ppn" => splitterMoney($this->input->post("ppn"),","),
            "is_pph" =>  $is_pph,
            "pph" => splitterMoney($this->input->post("pph"),","),
            "discount" => splitterMoney($this->input->post("discount"),","),
            "total" => splitterMoney($this->input->post("total"),","),
            "mata_uang" =>  $this->input->post("mata_uang"),
            "notes_tagihan" => $this->input->post("notes_tagihan"),
            "attachment" => $doc_data["file_name"],
            "dateline_invoice" => $this->input->post("dateline"),
            "status_lunas"=> 1,
            "id_user_add" => $this->session->id_user
        );
        insertRow("tagihan",$data);
        redirect("finance/payable");
    }
    public function pay($id_tagihan){ //sudah di cek
        //membuat status jadi lunas
        //masukin ke pembayaran
        //masukin ke tax (bila ada)
        
        $where = array(
            "id_tagihan" => $id_tagihan
        );
        /*masukin ke pembayaran*/
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
            "id_refrensi" => $id_tagihan,
            "subject_pembayaran" => $this->input->post("subject_pembayaran"),
            "tgl_bayar" => $this->input->post("tgl_bayar"),
            "attachment" =>  $fileData["file_name"],
            "notes_pembayaran" =>  $this->input->post("notes_pembayaran"),
            "nominal_pembayaran" =>  splitterMoney($this->input->post("nominal_pembayaran"),","),
            "kurs_pembayaran" =>  splitterMoney($this->input->post("kurs_pembayaran"),","),
            "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
            "total_pembayaran" => splitterMoney($this->input->post("nominal_pembayaran"),",")*splitterMoney($this->input->post("kurs_pembayaran"),","),
            "metode_pembayaran" => $this->input->post("metode_pembayaran"),
        );
        insertRow("pembayaran",$data);
    
        /*masukin ke tax */
        /*pajak pasti masukan karena ini kita bayar ke supplier*/
        $subtotal = get1Value("tagihan","subtotal",array("id_tagihan" => $id_tagihan));
        $diskon = get1Value("tagihan","discount",array("id_tagihan" => $id_tagihan));
        $tagihan = $subtotal-$diskon;

        if(get1Value("tagihan","is_ppn",array("id_tagihan" => $id_tagihan)) == 0){
            $data = array(
                "bulan_pajak" => date("m"),
                "tahun_pajak" => date("Y"),
                "jumlah_pajak" => 0.1*$tagihan,
                "tipe_pajak" => "MASUKAN",
                "jenis_pajak" => "PPN",
                "status_aktif_pajak" => 0,
                "id_refrensi" => $this->input->post("no_refrence")
            );
            insertRow("tax",$data);
        }
        
        if(get1Value("tagihan","is_pph",array("id_tagihan" => $id_tagihan)) == 0){
            $data = array(
                "bulan_pajak" => date("m"),
                "tahun_pajak" => date("Y"),
                "jumlah_pajak" => 0.02*$tagihan,
                "tipe_pajak" => "-",
                "jenis_pajak" => "PPH",
                "status_aktif_pajak" => 0,
                "id_refrensi" => $this->input->post("no_refrence")
            );
            insertRow("tax",$data);
        }
        $where = array(
            "id_tagihan" => $id_tagihan
        );
        $data = array(
            "status_lunas" => 0
        );
        updateRow("tagihan",$data,$where);
        redirect("finance/payable");
        /*selain ubah jadi paid, insert tax juga disini kalau emang dicentang di settingnya, cek is_ppn dan is_pph di db*/
    }
    public function remove($id_tagihan){ //sudah di cek
        $where = array(
            "id_tagihan" => $id_tagihan
        );
        $data = array(
            "status_aktif_invoice" => 1
        );
        updateRow("tagihan",$data,$where);
        redirect("finance/payable");
    }
    public function editinvoice(){ //sudah di cek
        $where = array(
            "id_tagihan" => $this->input->post("id_tagihan")
        );
        $check_ppn = $this->input->post("is_ppn");
        if(isChecked($check_ppn)) $is_ppn = 0; else $is_ppn = 1;
        $check_pph = $this->input->post("is_pph");
        if(isChecked($check_pph)) $is_pph = 0; else $is_pph = 1;

        $config["upload_path"] = './assets/dokumen/invoice/';
        $config["allowed_types"] = 'pdf|docx|doc|xls|xlsx|png|jpg|jpeg';
        $this->load->library("upload",$config);
        $doc_data = array();
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "no_invoice" => $this->input->post("no_invoice"),
                "no_refrence" => $this->input->post("no_refrence"),
                "peruntukan_tagihan" => $this->input->post("peruntukan_tagihan"),
                "rekening_pembayaran" => $this->input->post("rekening"),
                "subtotal" => splitterMoney($this->input->post("subtotal"),","),
                "is_ppn" =>  $is_ppn,
                "ppn" => splitterMoney($this->input->post("ppn"),","),
                "is_pph" =>  $is_pph,
                "pph" => splitterMoney($this->input->post("pph"),","),
                "discount" => splitterMoney($this->input->post("discount"),","),
                "total" => splitterMoney($this->input->post("total"),","),
                "mata_uang" =>  $this->input->post("mata_uang"),
                "notes_tagihan" => $this->input->post("notes_tagihan"),
                "attachment" => $fileData["file_name"],
                "dateline_invoice" => $this->input->post("dateline"),
            );
        }
        else{
            $data = array(
                "no_invoice" => $this->input->post("no_invoice"),
                "no_refrence" => $this->input->post("no_refrence"),
                "peruntukan_tagihan" => $this->input->post("peruntukan_tagihan"),
                "rekening_pembayaran" => $this->input->post("rekening"),
                "subtotal" => splitterMoney($this->input->post("subtotal"),","),
                "is_ppn" =>  $is_ppn,
                "ppn" => splitterMoney($this->input->post("ppn"),","),
                "is_pph" =>  $is_pph,
                "pph" => splitterMoney($this->input->post("pph"),","),
                "discount" => splitterMoney($this->input->post("discount"),","),
                "total" => splitterMoney($this->input->post("total"),","),
                "mata_uang" =>  $this->input->post("mata_uang"),
                "notes_tagihan" => $this->input->post("notes_tagihan"),
                "dateline_invoice" => $this->input->post("dateline"),
            );
        };
        
        updateRow("tagihan",$data,$where);
        redirect("finance/payable/edit/".$where["id_tagihan"]);
    }

}

?>