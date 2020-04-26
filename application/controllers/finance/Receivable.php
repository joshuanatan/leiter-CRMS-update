<?php
class Receivable extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdinvoice_core");
        $this->load->model("Mdorder_confirmation");
        $this->load->model("Mdmetode_pembayaran");
        $this->load->model("Mdinvoice_core");
        $this->load->model("Mdod_core");
        $this->load->library('Pdf');
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
        if($this->session->id_user == "") redirect("login/welcome");
        $where = array(
            "invoice_core.id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_receivable")) == 0){
            $where = array(
                "status_aktif_invoice" => 0,
                "invoice_core.id_user_add" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_receivable")) == 0){
            $where = array(
                "status_aktif_invoice" => 0
            );
        }
        $field = array(
            "id_submit_invoice","no_invoice","invoice_core.id_submit_oc","id_submit_od","nominal_pembayaran","tipe_invoice","kurs_pembayaran","mata_uang","is_ppn","ppn","invoice_core.franco","att","alamat_penagihan","status_lunas","jatuh_tempo","no_rekening","jumlah_box","berat_bersih","berat_kotor","dimensi","no_oc","no_po_customer"
        );
        $result = $this->Mdinvoice_core->getListInvoice($where,$field);
        $data["invoice"] = $result->result_array();
        for($a = 0; $a<count($data["invoice"]); $a++){
            switch($data["invoice"][$a]["tipe_invoice"]){
                case 1:
                $data["invoice"][$a]["purpose"] = "PELUNASAN UTUH";
                break;
                case 2:
                $data["invoice"][$a]["purpose"] = "PEMBAYARAN DP";
                break;
                case 3:
                $data["invoice"][$a]["purpose"] = "PELUNASAN (BER-DP)";
                break;
            }
        }
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/receivable/category-header");
        $this->load->view("finance/receivable/category-body",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    
    public function create(){
        $where = array(
            "oc" => array(
                "status_aktif_oc" => 0
            )   
        );
        $field["oc"] = array(
            "id_submit_oc","no_po_customer","id_submit_quotation",
        );
        $result["oc"] = $this->Mdorder_confirmation->getListOc($where["oc"]);
        $data["oc"] = foreachMultipleResult($result["oc"],$field["oc"],$field["oc"]);
        for($a = 0; $a<count($data["oc"]);$a++){
            $id_submit_request = get1Value("quotation","id_request",array("id_submit_quotation" => $data["oc"][$a]["id_submit_quotation"]));
            $id_cp = get1Value("price_request","id_cp",array("id_submit_request" => $id_submit_request));
            $id_perusahaan = get1Value("price_request","id_perusahaan",array("id_submit_request" => $id_submit_request));
            $data["oc"][$a]["id_perusahaan"] = $id_perusahaan;
            $data["oc"][$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan", array("id_perusahaan" => $id_perusahaan));
            $data["oc"][$a]["nama_cp"] = get1Value("contact_person","nama_cp", array("id_cp" => $id_cp));
            
            $data["oc"][$a]["not_new"] = isExistsInTable("invoice_core",array("id_submit_oc" => $data["oc"][$a]["id_submit_oc"],"status_aktif_invoice" => 0));
        }
        $data["maxId"] = getMaxId("invoice_core","id_invoice",array("bulan_invoice" => date("m"),"tahun_invoice" => date("Y"),"status_aktif_invoice" => 0));

        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/receivable/category-header");
        $this->load->view("finance/receivable/add-invoice",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function openDataEntry(){
        $where = array(
            "oc" => array(
                "status_aktif_oc" => 0
            )   
        );
        $field["oc"] = array(
            "id_submit_oc","no_po_customer","id_submit_quotation",
        );
        $result["oc"] = $this->Mdorder_confirmation->getListOc($where["oc"]);
        $data["oc"] = foreachMultipleResult($result["oc"],$field["oc"],$field["oc"]);
        for($a = 0; $a<count($data["oc"]);$a++){
            $id_submit_request = get1Value("quotation","id_request",array("id_submit_quotation" => $data["oc"][$a]["id_submit_quotation"]));
            $id_cp = get1Value("price_request","id_cp",array("id_submit_request" => $id_submit_request));
            $id_perusahaan = get1Value("price_request","id_perusahaan",array("id_submit_request" => $id_submit_request));
            $data["oc"][$a]["id_perusahaan"] = $id_perusahaan;
            $data["oc"][$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan", array("id_perusahaan" => $id_perusahaan));
            $data["oc"][$a]["nama_cp"] = get1Value("contact_person","nama_cp", array("id_cp" => $id_cp));
            
            $data["oc"][$a]["not_new"] = isExistsInTable("invoice_core",array("id_submit_oc" => $data["oc"][$a]["id_submit_oc"],"status_aktif_invoice" => 0));
        }
        $data["maxId"] = getMaxId("invoice_core","id_invoice",array("bulan_invoice" => date("m"),"tahun_invoice" => date("Y"),"status_aktif_invoice" => 0));

        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/receivable/category-header");
        $this->load->view("finance/receivable/data-entry-invoice",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function dataentry(){
        $input_data = array(
            "no_invoice" => $this->input->post("no_invoice"),
            "no_od" => $this->input->post("no_od"),
            "tgl_invoice" => $this->input->post("tgl_invoice"),
            "id_submit_oc" => $this->input->post("id_submit_oc"),
            "tipe_invoice" => $this->input->post("tipe_invoice"),
            "nominal_pembayaran" => $this->input->post("nominal_pembayaran"),
            "franco" => $this->input->post("franco"),
            "att" => $this->input->post("att"),
            "alamat_penagihan" => $this->input->post("alamat_penagihan"),
            "durasi_pembayaran" => $this->input->post("durasi_pembayaran"),
            "jatuh_tempo" => $this->input->post("jatuh_tempo"),
            "no_rekening" => $this->input->post("no_rekening")
        );
        if(in_array(null,$input_data)){
            $this->session->set_flashdata("invalid","[ DATA GAGAL DISUBMIT ] Terdapat form yang terlewat. Mohon lebih hati-hati");
            //print_r($input_data);
            redirect("finance/receivable/opendataentry");
        }
        $ppn_check = $this->input->post("ppn"); //centang ga centang gapapa
        $is_ppn = 1;
        $jumlah_ppn = 0;
        if($ppn_check != ""){
            foreach($ppn_check as $a){
                $is_ppn = 0;
                $jumlah_ppn = 0.1*splitterMoney($input_data["nominal_pembayaran"],",");
            }
        }
        $split = explode("-",$input_data["tgl_invoice"]);
        $bulan_input = $split[1];
        $tahun_input = $split[0];

        $id_submit_od = 0;
        if($input_data["no_od"] != "-"){
            $split = explode("/",$input_data["no_od"]);
            $no_od = $split[0];
            $id_od = substr($no_od,-3);
            $data = array(
                "id_submit_oc" => $input_data["id_submit_oc"],
                "id_od" => $id_od,
                "bulan_od" => $bulan_input,
                "tahun_od" => $tahun_input,
                "no_od" => $input_data["no_od"],
                "id_courier" => -1,
                "delivery_method" => "-",
                "alamat_pengiriman" => "-",
                "up_cp" => "-",
                "id_user_add" => $this->session->id_user
            );
            $id_submit_od = insertRow("od_core",$data);
            $item_oc = selectRow("order_confirmation_item",array("id_submit_oc" => $input_data["id_submit_oc"]),array("id_oc_item"));
            $array_item_oc = $item_oc->result_array();
            for($a = 0; $a<count($array_item_oc); $a++){
                $od_item = array(
                    "id_submit_od" => $id_submit_od, 
                    "id_oc_item" => $array_item_oc[$a]["id_oc_item"],
                    "item_qty" => 0
                );
                insertRow("od_item",$od_item);
            }
        }
        /*harusnya tambahin data od_item*/
        $no_invoice = $input_data["no_invoice"];
        $split = explode("/",$no_invoice);
        $id_invoice = substr($split[0],-2);
        $data = array(
            "id_invoice" =>  $id_invoice,
            "bulan_invoice" => $bulan_input,
            "tahun_invoice" => $tahun_input,
            "no_invoice" =>  $input_data["no_invoice"],
            "id_submit_oc" =>  $input_data["id_submit_oc"], 
            "tipe_invoice" =>  $input_data["tipe_invoice"],
            "id_submit_od" =>  $id_submit_od,
            "is_ppn" =>  $is_ppn,
            "ppn" =>  $jumlah_ppn,
            "franco" =>  $input_data["franco"],
            "att" =>  $input_data["att"],
            "alamat_penagihan" =>  $input_data["alamat_penagihan"],
            "durasi_pembayaran" =>  $input_data["durasi_pembayaran"],
            "jatuh_tempo" =>  $input_data["jatuh_tempo"],
            "nominal_pembayaran" =>  splitterMoney($input_data["nominal_pembayaran"],",")+$jumlah_ppn,
            "no_rekening" => $input_data["no_rekening"], 
            "jumlah_box" => 0,
            "berat_bersih" => 0,
            "berat_kotor" => 0,
            "dimensi" => "-",
            "id_user_add" => $this->session->id_user,
            "tgl_invoice_add" => $input_data["jatuh_tempo"] 
        );
        $id_submit_invoice = insertRow("invoice_core",$data);
        $checks = $this->input->post("checks");
        $maxVolumeBox = 0;
        $maxBoxDimensi = "";
        $beratBersih = 0;
        $beratKotor = 0;
        $jumlah_box = 0;
        if($checks != ""){
            
            foreach($checks as $checked){ //check ini apakah yang di check beneran ada datanya atau enggak
                $data = array(
                    "id_submit_invoice" => $id_submit_invoice,
                    "no_box" => $this->input->post("no_box".$checked),
                    "berat_bersih" => $this->input->post("berat_bersih".$checked),
                    "berat_kotor" => $this->input->post("berat_kotor".$checked),
                    "dimensi_box" => $this->input->post("dimensi_box".$checked),
                    "jumlah_box" => $this->input->post("jumlah_box".$checked),
                    
                );
                if(in_array("",$data)){ //kalau di centang tapi ada yang ga diisi

                }
                $split_satuan = explode(" ",$this->input->post("dimensi_box".$checked)); // 8*9*10 m => [8*9*10] [m]
                $split_box = explode("*",$split_satuan[0]); //8*9*10 => [8][9][10]
                if(count($split_satuan) != 2){ //berarti ada salah spasi dalam penginputan

                }
                else if(count($split_box) != 3){ //panjang lebar tinggi

                }
                else{
                    $insert_data = array(
                        "id_submit_invoice" => $id_submit_invoice,
                        "no_box" => $data["no_box"],
                        "berat_bersih" => $data["berat_bersih"],
                        "berat_kotor" => $data["berat_kotor"],
                        "dimensi_box" => $data["dimensi_box"],
                        
                    );
                    insertRow("invoice_packaging_box",$insert_data);
                    //echo "\$jumlah box".$jumlah_box;
                    //echo "jumlahbox array".$data["jumlah_box"];
                    $jumlah_box += $data["jumlah_box"];
                    $beratBersih += $data["berat_bersih"]*$data["jumlah_box"];
                    $beratKotor += $data["berat_kotor"]*$data["jumlah_box"];
                    
                    $volumeBox = 1;
                    for($a = 0; $a<count($split_box); $a++){
                        $volumeBox *= $split_box[$a];
                    }
                    if($volumeBox > $maxVolumeBox ){
                        $maxVolumeBox = $volumeBox;
                        $maxBoxDimensi = $this->input->post("dimensi_box".$checked);
                    }
                }
            }
        }

        if($jumlah_box > 0){
            $where = array(
                "id_submit_invoice" => $id_submit_invoice,
            );
            $data = array(
                "jumlah_box" => $jumlah_box,
                "berat_bersih" => $beratBersih,
                "berat_kotor" => $beratKotor,
                "dimensi" => $maxBoxDimensi,
            );
            updateRow("invoice_core",$data,$where);
        }
        redirect("finance/receivable");
    }
    public function createinvoice(){
        $ppn_check = $this->input->post("ppn");
        $is_ppn = 1;
        foreach($ppn_check as $a){
            $is_ppn = 0;
        }
        $jumlah_ppn = 0;
        if($is_ppn == 0){
            $jumlah_ppn = 0.1*splitterMoney($this->input->post("nominal_pembayaran"),",");
        }
        if($this->input->post("id_od") == "") $id_od = "-"; else $id_od = $this->input->post("id_od");
        $data = array(
            "id_invoice" =>  $this->input->post("id_invoice"),
            "bulan_invoice" => date("m"),
            "tahun_invoice" => date("Y"),
            "no_invoice" =>  $this->input->post("no_invoice"),
            "id_submit_oc" =>  $this->input->post("id_submit_oc"), 
            "tipe_invoice" =>  $this->input->post("tipe_invoice"),
            "id_submit_od" =>  $id_od,
            "is_ppn" =>  $is_ppn,
            "ppn" =>  $jumlah_ppn,
            "franco" =>  $this->input->post("franco"),
            "att" =>  $this->input->post("att"),
            "alamat_penagihan" =>  $this->input->post("alamat_penagihan"),
            "durasi_pembayaran" =>  $this->input->post("durasi_pembayaran"),
            "jatuh_tempo" =>  $this->input->post("jatuh_tempo"),
            "nominal_pembayaran" =>  splitterMoney($this->input->post("nominal_pembayaran"),",")+$jumlah_ppn,
            "no_rekening" => $this->input->post("no_rekening"), 
            "sign_off" => $this->input->post("sign_off"), 
            "jumlah_box" => 0,
            "berat_bersih" => 0,
            "berat_kotor" => 0,
            "dimensi" => "-",
            "id_user_add" => $this->session->id_user 
        );
        /*
        if(in_array("",$data)){
            $this->session->set_flashdata("invalid","Form belum lengkap, mohon dilengkapi da")
        }
        */
        $id_submit_invoice = insertRow("invoice_core",$data);

        $checks = $this->input->post("checks");
        $maxVolumeBox = 0;
        $maxBoxDimensi = "";
        $beratBersih = 0;
        $beratKotor = 0;
        $jumlah_box = 0;
        if($checks != ""){
            foreach($checks as $checked){
                $data = array(
                    "id_submit_invoice" => $id_submit_invoice,
                    "no_box" => $this->input->post("no_box".$checked),
                    "berat_bersih" => $this->input->post("berat_bersih".$checked),
                    "berat_kotor" => $this->input->post("berat_kotor".$checked),
                    "dimensi_box" => $this->input->post("dimensi_box".$checked),
                );
                insertRow("invoice_packaging_box",$data);
                $box_amount = $this->input->post("jumlah_box".$checked);
                $jumlah_box += $box_amount;
                $beratBersih += $this->input->post("berat_bersih".$checked)*$box_amount;
                $beratKotor += $this->input->post("berat_kotor".$checked)*$box_amount;
                $split_satuan = explode(" ",$this->input->post("dimensi_box".$checked)); // 8*9*10 m => [8*9*10] [m]
                $split_box = explode("*",$split_satuan[0]); //8*9*10 => [8][9][10]
                $volumeBox = 1;
                for($a = 0; $a<count($split_box); $a++){
                    $volumeBox *= $split_box[$a];
                }
                if($volumeBox > $maxVolumeBox ){
                    $maxVolumeBox = $volumeBox;
                    $maxBoxDimensi = $this->input->post("dimensi_box".$checked);
                }
            }
        }

        if($jumlah_box > 0){
            $where = array(
                "id_submit_invoice" => $id_submit_invoice,
            );
            $data = array(
                "jumlah_box" => $jumlah_box,
                "berat_bersih" => $beratBersih,
                "berat_kotor" => $beratKotor,
                "dimensi" => $maxBoxDimensi,
            );
            updateRow("invoice_core",$data,$where);
        }
        redirect("finance/receivable");
    }
    public function edit($id_submit_invoice){
        $where = array(
            "id_submit_invoice" => $id_submit_invoice
        );
        $field = array(
            "no_invoice","id_submit_oc","no_oc","no_po_customer","nama_perusahaan","nama_cp","franco_invoice","nominal_invoice","total_oc_price","att","jatuh_tempo","durasi_pembayaran","alamat_penagihan","tipe_invoice","id_submit_invoice","is_ppn","no_rekening","sign_off","id_invoice","bulan_invoice","tahun_invoice"
        );
        $result = selectRow("detail_invoice",$where,$field);
        $data["invoice"] = $result->result_array();
        if($data["invoice"][0]["is_ppn"] == 0){
            $data["invoice"][0]["nominal_invoice"] = $data["invoice"][0]["nominal_invoice"]*10/11;
        }
        $where = array(
            "id_submit_oc" => $data["invoice"][0]["id_submit_oc"]
        );
        $field = array(
            "id_submit_od","no_od"
        );
        $result = selectRow("od_core",$where,$field);
        $data["od"] = $result->result_array();

        $where = array(
            "id_submit_invoice" => $id_submit_invoice
        );
        $field = array(
            "id_packaging","id_submit_invoice","no_box","berat_bersih","berat_kotor","dimensi_box"
        );
        $result = selectRow("invoice_packaging_box",$where,$field);
        $data["box"] = $result->result_array();
        $this->req();
        $this->load->view("finance/content-open");
        $this->load->view("finance/receivable/category-header");
        $this->load->view("finance/receivable/edit-invoice",$data);
        $this->load->view("finance/content-close");
        $this->close();
    }
    public function pay($id_submit_invoice){
        $where = array(
            "id_submit_invoice" => $id_submit_invoice
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
            "id_refrensi" => $this->input->post("id_refrensi"),
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
        //print_r($data);
        insertRow("pembayaran_customer",$data);
        
        /*sekarang yang di metode pembayaran*/
        $tipe_invoice = get1Value("invoice_core","tipe_invoice",array("id_submit_invoice" => $id_submit_invoice));
        switch($tipe_invoice){
            case 1: //invoice tipe 1 dan 3 adalah pelunasan
            case 3: //invoice tipe 1 dan 3 adalah pelunasan
            $data["status_bayar"] = array(
                "status_bayar2" => 0
            );
            break;
            case 2: //invoice tipe 2 adalah DP
            $data["status_bayar"] = array(
                "status_bayar" => 0
            );
        }
        $id_submit_oc =  get1Value("invoice_core","id_submit_oc",array("id_submit_invoice" => $id_submit_invoice)); //cari id_submit_oc dari tabel invoice

        updateRow("order_confirmation_metode_pembayaran",$data["status_bayar"],array("id_submit_oc" => $id_submit_oc)); //update oc_metode_pembayaran menggunakan id_submit_oc

        /*masukin ke tax */
        /*pajak pasti masukan karena ini kita bayar ke supplier*/
        $tagihan = splitterMoney($this->input->post("nominal_pembayaran"),",");


        if(get1Value("invoice_core","is_ppn",array("id_submit_invoice" => $id_submit_invoice)) == 0){ //kalau ada PPn
            $data = array(
                "bulan_pajak" => date("m"),
                "tahun_pajak" => date("Y"),
                "jumlah_pajak" => $tagihan/11, /*tagihan ini uda termasuk ppn, ahrus cari ppnnya sendiri*/
                "tipe_pajak" => "KELUARAN",
                "jenis_pajak" => "PPN",
                "status_aktif_pajak" => 0,
                "id_refrensi" => $this->input->post("no_refrence")
            );
            insertRow("tax",$data);
        }
        $where = array(
            "id_submit_invoice" => $id_submit_invoice
        );
        $data = array(
            "status_lunas" => 0
        );
        updateRow("invoice_core",$data,$where);
        redirect("finance/receivable");
    }
    public function delete($id_submit_invoice){
        $where = array(
            "id_submit_invoice" => $id_submit_invoice
        );
        $data = array(
            "status_aktif_invoice" => 1
        );
        updateRow("invoice_core",$data,$where);
        redirect("finance/receivable");
    }
    function invoicePdf($id_submit_invoice){
        $where=array(
            "id_submit_invoice"=>$id_submit_invoice,
        );

        $this->load->model('M_pdf_invoice');
        $invoice = $this->M_pdf_invoice->selectInvoice($where);
        $perusahaan = $this->M_pdf_invoice->selectPerusahaan($where);

        $cekOd = get1Value("invoice_core","id_submit_od",array("id_submit_invoice"=>$id_submit_invoice));

        if($cekOd=="0"){
            $barang = $this->M_pdf_invoice->selectBarangOc($where);
        }else{
            $barang = $this->M_pdf_invoice->selectBarangOd($where);
        }

        $jalan = $this->M_pdf_invoice->selectJalan($where);

        $dp = $this->M_pdf_invoice->selectDp($where);
        $box = $this->M_pdf_invoice->selectBox($where);
        $data=array(
            "invoice"=>$invoice,
            "perusahaan"=>$perusahaan,
            "barang"=>$barang,
            "jalan"=>$jalan,
            "dp"=>$dp,
            "cekOd"=>$cekOd,
            "box"=>$box,
        );

        $tipe_invoice = get1Value("invoice_core","tipe_invoice",array("id_submit_invoice"=>$id_submit_invoice));
        
        if($tipe_invoice=="1"){
            $this->load->view('finance/receivable/pdf_invoice',$data);
        }else if($tipe_invoice=="2"){
            $this->load->view('finance/receivable/pdf_invoice2',$data);
        }else{
            $this->load->view('finance/receivable/pdf_invoice3',$data);
        }
        
    }
    public function editinvoice(){
        $id_submit_invoice = $this->input->post("id_submit_invoice");
        $no_invoice = $this->input->post("no_invoice");
        deleteRow("tax",array("no_refrence",$no_invoice));
        $ppn_check = $this->input->post("ppn");
        $is_ppn = 1;
        foreach($ppn_check as $a){
            $is_ppn = 0;
        }
        $jumlah_ppn = 0;
        if($is_ppn == 0){
            $jumlah_ppn = 0.1*splitterMoney($this->input->post("nominal_pembayaran"),",");
        }

        $data = array(
            "no_invoice" => $this->input->post("no_invoice"),
            "id_invoice" => $this->input->post("id_invoice"),
            "tahun_invoice" => $this->input->post("tahun_invoice"),
            "bulan_invoice" => $this->input->post("bulan_invoice"),
            "tipe_invoice" => $this->input->post("tipe_invoice"),
            "id_submit_od" => $this->input->post("od"),
            "is_ppn" =>  $is_ppn,
            "ppn" =>  $jumlah_ppn,
            "franco" =>  $this->input->post("franco"),
            "att" =>  $this->input->post("att"),
            "alamat_penagihan" =>  $this->input->post("alamat_penagihan"),
            "durasi_pembayaran" =>  $this->input->post("durasi_pembayaran"),
            "jatuh_tempo" =>  $this->input->post("jatuh_tempo"),
            "nominal_pembayaran" =>  splitterMoney($this->input->post("nominal_pembayaran"),",")+$jumlah_ppn,
            "no_rekening" => $this->input->post("no_rekening"), 
            "sign_off" => $this->input->post("sign_off"), 
            "jumlah_box" => 0,
            "berat_bersih" => 0,
            "berat_kotor" => 0,
            "dimensi" => "-",
            "id_user_edit" => $this->session->id_user,
            "tgl_invoice_edit" => date("Y-m-d") 
        );
        $where = array(
            "id_submit_invoice" => $id_submit_invoice
        );
        updateRow("invoice_core",$data,$where);

        $checks = $this->input->post("checks");
        $maxVolumeBox = 0;
        $maxBoxDimensi = "";
        $beratBersih = 0;
        $beratKotor = 0;
        $jumlah_box = 0;
        if($checks != ""){
            foreach($checks as $checked){
                $id_packaging = $this->input->post("id_packaging".$checked);
                if($id_packaging != ""){
                    //update
                    $where = array(
                        "id_packaging" => $id_packaging
                    );
                    $data = array(
                        "no_box" => $this->input->post("no_box".$checked),
                        "berat_bersih" => $this->input->post("berat_bersih".$checked),
                        "berat_kotor" => $this->input->post("berat_kotor".$checked),
                        "dimensi_box" => $this->input->post("dimensi_box".$checked),
                    );
                    updateRow("invoice_packaging_box",$data,$where);
                }
                else{
                    //insert
                    $data = array(
                        "id_submit_invoice" => $id_submit_invoice,
                        "no_box" => $this->input->post("no_box".$checked),
                        "berat_bersih" => $this->input->post("berat_bersih".$checked),
                        "berat_kotor" => $this->input->post("berat_kotor".$checked),
                        "dimensi_box" => $this->input->post("dimensi_box".$checked),
                    );
                    insertRow("invoice_packaging_box",$data);
                }
                $box_amount = $this->input->post("jumlah_box".$checked);
                $jumlah_box += $box_amount;
                $beratBersih += $this->input->post("berat_bersih".$checked)*$box_amount;
                $beratKotor += $this->input->post("berat_kotor".$checked)*$box_amount;
                $split_satuan = explode(" ",$this->input->post("dimensi_box".$checked)); // 8*9*10 m => [8*9*10] [m]
                $split_box = explode("*",$split_satuan[0]); //8*9*10 => [8][9][10]
                $volumeBox = 1;
                for($a = 0; $a<count($split_box); $a++){
                    $volumeBox *= $split_box[$a];
                }
                if($volumeBox > $maxVolumeBox ){
                    $maxVolumeBox = $volumeBox;
                    $maxBoxDimensi = $this->input->post("dimensi_box".$checked);
                }
            }
        }
        $delete = $this->input->post("delete");
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_packaging" => $deleted
                );
                deleteRow("invoice_packaging_box",$where);
            }
        }
        if($jumlah_box > 0){
            $where = array(
                "id_submit_invoice" => $id_submit_invoice,
            );
            $data = array(
                "jumlah_box" => $jumlah_box,
                "berat_bersih" => $beratBersih,
                "berat_kotor" => $beratKotor,
                "dimensi" => $maxBoxDimensi,
            );
            updateRow("invoice_core",$data,$where);
        }
        redirect("finance/receivable");
    }
}
?>