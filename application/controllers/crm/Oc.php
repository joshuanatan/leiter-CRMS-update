<?php
class Oc extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdquotation");
        $this->load->model("Mdorder_confirmation");
        $this->load->model("Mdquotation_item");
        $this->load->model("Mdod_item");
        $this->load->model("Mdod_core");
        $this->load->model("Mdorder_confirmation_item");
        $this->load->model("Mdmetode_pembayaran");
        $this->load->model("Mdperusahaan");
        $this->load->library('Pdf_oc');
    }
    /*defaul function*/
    private function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("crm/crm-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("crm/oc/js/form-script");
        $this->load->view("crm/crm-close");
        $this->load->view("req/html-close");
    }
    /*page*/
    public function index(){
        $this->session->page = 1;
        if($this->session->id_user == "") redirect("login/welcome");
        $this->session->unset_userdata("id_submit_quotation"); //setelah insert oc yang butuh id quotation
        $this->removeFilter();
        redirect("crm/oc/page/".$this->session->page);
    }
    
    public function create(){ //sudah di cek 
        if($this->session->id_user == ""){
            redirect("welcome");
        }
        if($this->session->id_submit_quotation == ""){
            $this->session->id_submit_quotation = $this->input->post("id_submit_quotation");
        }
        $where = array(
            "id_submit_quotation" => $this->session->id_submit_quotation
        );
        $field = array(
            "nama_perusahaan","nama_cp","total_quotation_price","alamat_perusahaan","no_quotation","hal_quotation","up_cp_quotation","durasi_pengiriman_quotation","franco_quotation","durasi_pembayaran_quotation","alamat_perusahaan"
        );
        $result = selectRow("order_detail",$where,$field);
        $data["oc"] = $result->result_array();
        $data["maxId"] = getMaxId("order_confirmation","id_oc",array("bulan_oc" => date("m"), "tahun_oc" => date("Y")));

        $where = array(
            "id_submit_quotation" => $this->session->id_submit_quotation,
        );
        $field = array(
            "nama_produk_leiter","item_amount_quotation","satuan_produk_quotation","selling_price_quotation","id_quotation_item"
        );
        $result = selectRow("order_item_detail",$where,$field);
        $data["items"] = $result->result_array();

        $where = array(
            "id_submit_quotation" => $this->session->id_submit_quotation
        );
        $field = array(
            "persentase_pembayaran","nominal_pembayaran","trigger_pembayaran","is_ada_transaksi","persentase_pembayaran2","nominal_pembayaran2","trigger_pembayaran2","is_ada_transaksi2","kurs"
        );
        $result = selectRow("quotation_metode_pembayaran",$where,$field);
        $data["metode_pembayaran"] = $result->result_array();
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/oc/category-header");
        $this->load->view("crm/oc/add-oc",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function edit($id_submit_oc){ //sudah di cek
        $where = array(
            "id_submit_oc" => $id_submit_oc
        );
        $field = array(
            "id_submit_quotation","no_oc","id_submit_oc","total_oc_price","no_po_customer","tgl_po_customer","up_cp_oc","durasi_pengiriman_oc","metode_pengiriman","franco_oc","durasi_pembayaran_oc","nama_perusahaan","nama_cp","alamat_perusahaan_oc","id_oc","tahun_oc","bulan_oc"
        );
        $result = selectRow("order_detail",$where,$field);
        $data["detail"] = $result->result_array();

        $id_submit_quotation = get1Value("order_detail","id_submit_quotation",array("id_submit_oc" => $id_submit_oc));
        $where = array(
            "id_submit_quotation" => $id_submit_quotation
        );
        $field = array(
            "nama_oc_item","final_amount_oc","satuan_produk_oc","final_selling_price_oc","status_oc_item","id_quotation_item","nama_produk_leiter","item_amount_quotation","satuan_produk_quotation","selling_price_quotation","margin_price_quotation","id_oc_item","deskripsi_produk","id_produk"
        );
        $result = selectRow("order_item_detail",$where,$field);
        $data["items"] = $result->result_array();

        $where = array(
            "id_submit_oc" => $id_submit_oc
        );
        $field = array(
            "persentase_pembayaran","nominal_pembayaran","trigger_pembayaran","status_bayar","is_ada_transaksi","persentase_pembayaran2","nominal_pembayaran2","trigger_pembayaran2","status_bayar2","is_ada_transaksi2","kurs"
        );
        $result = selectRow("order_confirmation_metode_pembayaran",$where);
        $data["pembayaran"] = $result->result_array();
        
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/oc/category-header");
        $this->load->view("crm/oc/edit-oc",$data);
        $this->load->view("crm/content-close");
        $this->close();

    }
    /*function*/
    public function editoc(){ //sudah di cek
        /*insert ke oc tanpa total_oc_price*/
        $where["main"] = array(
            "id_submit_oc" => $this->input->post("id_submit_oc")
        );
        $data = array(
            "no_oc" => $this->input->post("no_oc"),
            "id_oc" => $this->input->post("id_oc"),
            "tahun_oc" => $this->input->post("tahun_oc"),
            "bulan_oc" => $this->input->post("bulan_oc"),
            "no_po_customer" => $this->input->post("no_po_customer"),
            "tgl_po_customer" => $this->input->post("tgl_po_customer"),
            "up_cp" => $this->input->post("up_cp"),
            "durasi_pengiriman" => $this->input->post("durasi_pengiriman"),
            "metode_pengiriman" => $this->input->post("metode_pengiriman"),
            "franco" => $this->input->post("franco"),
            "durasi_pembayaran" => $this->input->post("durasi_pembayaran"),
            "alamat_perusahaan_oc" => $this->input->post("alamat_perusahaan_oc"),
            "total_oc_price" => splitterMoney($this->input->post("total_oc_price"),","),
        );
        if(in_array("",$data)){
            $this->session->set_flashdata("invalid","[Data gagal diupdate] Terdapat form yang kosong, mohon mengisi dengan hati-hati");
            $report = "Your Input Before: ";
            foreach($data as $key => $value){
                $report .= $key." = ".$value."<br/>";
            }
            $this->session->set_flashdata("report",$report);
            redirect("crm/oc/edit/".$this->input->post("id_submit_oc"));
        }
        updateRow("order_confirmation",$data,$where["main"]);
        /*insert ke item oc*/

        
        $checks = $this->input->post("checks");
        $delete = $this->input->post("delete");
        if($checks != ""){
            foreach($checks as $checked){
                $amount = $this->input->post("final_amount".$checked);
                if($amount == ""){
                    $this->session->set_flashdata("invalid","Mohon jumlah produk diisi");
                    redirect("crm/oc/create");
                }
                else{
                    $split = explode(" ",$amount);
                    if(count($split) == 1){
                        $split[1] = "-"; //yang satuan, ada chance dikosongin
                    } 
                }
                $nama_item_oc = $this->input->post("nama_oc_item".$checked);
                if($nama_item_oc == ""){
                    $nama_item_oc = "-";
                }
                $id_produk = $this->input->post("id_produk".$checked);
                if($id_produk == ""){
                    $id_produk = -1;
                }

                if($this->input->post("status_ada_item".$checked) != ""){
                    $where = array(
                        "id_oc_item" => $this->input->post("status_ada_item".$checked)
                    );
                    $data = array(
                        "id_submit_oc" => $this->input->post("id_submit_oc"),
                        "id_quotation_item" => $checked, /*quotation barang 1*/
                        "nama_oc_item" => $nama_item_oc, /*nama produk oc barang 1*/
                        "final_amount" => $split[0], /*3*/
                        "satuan_produk" => $split[1], /*meter*/
                        "final_selling_price" =>splitterMoney($this->input->post("final_selling_price".$checked),","),
                        "id_produk" => $id_produk
                    );
                    if(in_array("",$data)){
                        $this->session->set_flashdata("invalid","Mohon mengisi produk dengan benar");
                        $report = "Your Input Before: ";
                        foreach($data as $key => $value){
                            $report .= $key." = ".$value."<br/>";
                        }
                        $this->session->set_flashdata("report",$report);
                        redirect("crm/oc/create");
                    }
                    updateRow("order_confirmation_item",$data,$where);
                    /*ada isinya*/
                }
                else{
                    $data = array(
                        "id_oc_item" => getMaxId("order_confirmation_item","id_oc_item",array()),
                        "id_submit_oc" => $this->input->post("id_submit_oc"),
                        "id_quotation_item" => $checked, /*quotation barang 1*/
                        "nama_oc_item" => $nama_item_oc, /*nama produk oc barang 1*/
                        "final_amount" => $split[0], /*3*/
                        "satuan_produk" => $split[1], /*meter*/
                        "final_selling_price" =>splitterMoney($this->input->post("final_selling_price".$checked),","),
                        "id_produk" => $id_produk
                    );
                    if(in_array("",$data)){
                        $this->session->set_flashdata("invalid","Mohon mengisi produk dengan benar");
                        $report = "Your Input Before: ";
                        foreach($data as $key => $value){
                            $report .= $key." = ".$value."<br/>";
                        }
                        $this->session->set_flashdata("report",$report);
                        redirect("crm/oc/create");
                    }
                    insertRow("order_confirmation_item",$data);
                    /*baru*/
                }
            }
        }
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_oc_item" => $deleted
                );
                deleteRow("order_confirmation_item",$where);
            }
        }
        /*masukin metode pembayaran*/
        
        $is_ada_transaksi = 0;
        if($this->input->post("persentase_pembayaran") == 0){ //persentase DP 0
            $is_ada_transaksi = 1;
        }
        $is_ada_transaksi2 = 0;
        if($this->input->post("persentase_pembayaran2") == 0){ //persentase pelunasan 0
            $is_ada_transaksi2 = 1;
        }
        $data["pembayaran"] = array(
            "persentase_pembayaran" => $this->input->post("persentase_pembayaran"),
            "nominal_pembayaran" => splitterMoney($this->input->post("nominal_pembayaran"),","),
            "trigger_pembayaran" => $this->input->post("trigger_pembayaran"),
            "status_bayar" => 1,
            "is_ada_transaksi" => $is_ada_transaksi,
            "persentase_pembayaran2" => $this->input->post("persentase_pembayaran2"),
            "nominal_pembayaran2" => splitterMoney($this->input->post("nominal_pembayaran2"),","),
            "trigger_pembayaran2" => $this->input->post("trigger_pembayaran2"),
            "status_bayar2" => 1,
            "is_ada_transaksi2" => $is_ada_transaksi2,
            "kurs" => $this->input->post("mata_uang_pembayaran")
        );
        
        $where["main"] = array(
            "id_submit_oc" => $this->input->post("id_submit_oc")
        );
        updateRow("order_confirmation_metode_pembayaran",$data["pembayaran"],$where["main"]);
        /*end metode pembayaran*/
        //$this->session->set_flashdata("invalid","[DATA TIDAK ADA YANG DIUPDATE] Mohon menunggu, sedang dalam masa percobaan");
        redirect("crm/oc/page/".$this->session->page);
    }   
    public function openDataEntry(){
        $where = array(
            "customer" => array(
                "peran_perusahaan" => "CUSTOMER",
                "status_perusahaan" => "0"
            )
        );
        $result = $this->Mdperusahaan->select($where["customer"]);
        $field["customer"] = array(
            "id_cp","nama_cp","id_perusahaan","nama_perusahaan"
        );
        $data = array(
            "customer" => foreachMultipleResult($result,$field["customer"],$field["customer"])
        );
        $where = array(
            "status_produk" => 0
        );  
        $result = selectRow("produk",$where);
        $field["produk"] = array(
            "id_produk","nama_produk"
        );
        $data["produk"] = foreachMultipleResult($result,$field["produk"],$field["produk"]);
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/oc/category-header");
        $this->load->view("crm/oc/data-entry-oc",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function dataentry(){ //sudah di cek
        try{
            $input_data = array(
                "id_perusahaan" => $this->input->post("id_perusahaan"),
                "no_po_customer" => $this->input->post("no_po_customer"),
                "no_oc" => $this->input->post("no_oc"),
                "franco" => $this->input->post("franco"),
                "tgl_po_customer" => $this->input->post("tgl_po_customer"),
                "total_oc_price" => $this->input->post("total_oc_price"),
                "persentase_pembayaran" => $this->input->post("persentase_pembayaran"),
                "persentase_pembayaran2" => $this->input->post("persentase_pembayaran2"),
                "nominal_pembayaran" => $this->input->post("nominal_pembayaran"),
                "trigger_pembayaran" => $this->input->post("trigger_pembayaran"),
                "nominal_pembayaran2" => $this->input->post("nominal_pembayaran2"),
                "trigger_pembayaran2" => $this->input->post("trigger_pembayaran2"),
                "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
                "up_cp" => $this->input->post("up_cp"),
                "durasi_pembayaran" => $this->input->post("durasi_pembayaran"),
                "durasi_pengiriman" => $this->input->post("durasi_pengiriman"),
                "metode_pengiriman" => $this->input->post("metode_pengiriman"),
            );
            if(in_array("",$input_data)){
                $this->session->set_flashdata("invalid","[ DATA GAGAL DISUBMIT ] Terdapat form yang terlewat. Mohon lebih hati-hati");
                redirect("crm/oc/opendataentry");
            }
            if($this->session->id_user == ""){
                redirect("welcome");
            }
            $split = explode("-",$input_data["id_perusahaan"]);
            if(count($split) != 2){
                $this->session->set_flashdata("invalid","[ DATA GAGAL DISUBMIT ] Perusahaan tidak ditemukan");
                redirect("crm/oc/opendataentry");
            }
            $input_data["id_perusahaan"] = $split[0]; //ini perusahaan gapunya cp
            $input_data["id_cp_perusahaan"] = $split[1]; //ini perusahaan ga punya cp

            $split = explode("-",$input_data["tgl_po_customer"]);
            $tahun_input = $split[0];
            $bulan_input = $split[1];

            $is_ada_transaksi = 0;
            if($input_data["persentase_pembayaran"] == 0){ //persentase DP 0
                $is_ada_transaksi = 1;
            }
            $is_ada_transaksi2 = 0;
            if($input_data["persentase_pembayaran2"] == 0){ //persentase pelunasan 0
                $is_ada_transaksi2 = 1;
            }
            $input_data += array(
                "nama_oc_item" => $this->input->post("nama_oc_item"),
                "id_produk" => $this->input->post("id_produk"),
                "final_amount" => $this->input->post("final_amount"),
                "final_selling_price" => $this->input->post("final_selling_price"),
            );
            $category = array();
            $urutan = 0;
            foreach($input_data["id_produk"] as $a){
                if($a == 0) break;
                $category[$urutan]["id_produk"] = $a; /*variable ini urutan 1, 2, 3, 4, dst*/
                $urutan++;
            }
            $urutan = 0;
            foreach($input_data["nama_oc_item"] as $a){
                if($a == "") break;
                $category[$urutan]["nama_oc_item"] = $a; /*variable ini urutan 1, 2, 3, 4, dst*/
                $urutan++;
            }
            $urutan = 0;
            foreach($input_data["final_amount"] as $a){
                if($a == "") break;
                $category[$urutan]["final_amount"] = $a; /*variable ini urutan 1, 2, 3, 4, dst*/
                $split = explode(" ",$category[$urutan]["final_amount"]);
                if(count($split) != 2){
                    $this->session->set_flashdata("invalid","[ DATA GAGAL DISUBMIT ] Format satuan tolong diperhatikan");
                    redirect("crm/oc/opendataentry");
                }
                $category[$urutan]["jumlah"] = $split[0];
                $category[$urutan]["satuan"] = $split[1];
                $urutan++;
            }
            $urutan = 0;
            foreach($input_data["final_selling_price"] as $a){
                if($a == "") break;
                $category[$urutan]["final_selling_price"] = splitterMoney($a,","); /*variable ini urutan 1, 2, 3, 4, dst*/
                $urutan++;
            }
            
            $id_request = getMaxId("price_request","id_request",array("bulan_request" => $bulan_input,"tahun_request" => $tahun_input, "status_aktif_request" => 0));
            
            $no_request =  "LI-".sprintf("%03d",$id_request)."/RFQ/".bulanRomawi($bulan_input)."/".$tahun_input;
            $id_quotation = getMaxId("quotation","id_quotation",array("status_aktif_quotation" => 0,"bulan_quotation" => $bulan_input,"tahun_quotation" => $tahun_input));
            
            $no_quotation =  "LI-".sprintf("%03d",$id_quotation)."/QUO/".bulanRomawi($bulan_input)."/".$tahun_input;
            
            $id_oc = substr($input_data["no_oc"],-4); //LI20190003 = 0003 => 3
            /*end of load data, masuk bagian checkingnya*/

            
        }
        catch(Exception $e){
            $this->session->set_flashdata("error_input","[ DATA GAGAL DISUBMIT ] there are some errors, please becareful on data input");
            redirect("crm/oc/opendataentry");
        }
        finally{
            $data = array(
                "id_request" => $id_request,
                "status_aktif_request" => 0,
                "bulan_request" => $bulan_input,
                "tahun_request" => $tahun_input,
                "no_request" => $no_request,
                "id_perusahaan" => $input_data["id_perusahaan"], // customer
                "id_cp" => $input_data["id_cp_perusahaan"],
                "franco" => $input_data["franco"],
                "untuk_stock" => 1,
                "tgl_dateline_request" => $input_data["tgl_po_customer"],
                "status_buat_quo" => 0,
                "status_request" => 3,
                "date_request_add" => $input_data["tgl_po_customer"]
            );
            $id_submit_request = insertRow("price_request",$data);

            $data = array(
                "id_quotation" => $id_quotation,
                "bulan_quotation" => $bulan_input,
                "tahun_quotation" => $tahun_input,
                "versi_quotation" => 1,
                "no_quotation" => $no_quotation,
                "id_request" => $id_submit_request,
                "total_quotation_price" =>  splitterMoney($input_data["total_oc_price"],","), //nanti ini diisi setelah quotation item ketotal
                "hal_quotation" => "-",
                "up_cp" => $input_data["up_cp"],
                "durasi_pengiriman" => $input_data["durasi_pengiriman"],
                "franco" => $input_data["franco"],
                "durasi_pembayaran" => $input_data["durasi_pembayaran"], 
                "alamat_perusahaan" => "-",
                "dateline_quotation" =>  $input_data["tgl_po_customer"],
                "status_quotation" => 2,
                "id_user_add" => $this->session->id_user,
                "date_quotation_add" => $input_data["tgl_po_customer"]
            );
            $id_submit_quotation = insertRow("quotation",$data);
            
            $data = array(
                "id_submit_quotation" => $id_submit_quotation,
                "id_oc" => $id_oc,
                "bulan_oc" => $bulan_input,
                "tahun_oc" => $tahun_input,
                "no_oc" => $input_data["no_oc"],
                "no_po_customer" => $input_data["no_po_customer"],
                "tgl_po_customer" => $input_data["tgl_po_customer"],
                "total_oc_price" =>  splitterMoney($input_data["total_oc_price"],","),
                "up_cp" => $input_data["up_cp"],
                "durasi_pembayaran" => $input_data["durasi_pembayaran"],
                "durasi_pengiriman" => $input_data["durasi_pengiriman"],
                "metode_pengiriman" => $input_data["metode_pengiriman"],
                "franco" => $input_data["franco"],
                "id_user_add" => $this->session->id_user,
                "date_oc_add" => $input_data["tgl_po_customer"]
            );
            $id_submit_oc = insertRow("order_confirmation",$data);

            /*nanti di loop sesuai yang dicentang yang dimasukin dari oc item*/
            for($a = 0; $a<count($category); $a++){
                $data = array(
                    "id_submit_request" => $id_submit_request,
                    "nama_produk" => $category[$a]["nama_oc_item"], //kenapa error lagi pas di live z
                    "jumlah_produk" => $category[$a]["jumlah"],
                    "satuan_produk" => $category[$a]["satuan"],
                    "notes_produk" => "-",
                    "file" => "-",
                    "id_user_add" => $this->session->id_user
                );
                $id_request_item = insertRow("price_request_item",$data);
                $data = array(
                    "id_request_item" => $id_request_item,
                    "id_perusahaan" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "id_cp" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "harga_produk" => 1, //gaperlu masukin karena gapenting
                    "vendor_price_rate" => 1, //gaperlu masukin karena gapenting
                    "mata_uang" => "-",
                    "nama_produk_vendor" => "-",
                    "notes" => "-",
                    "attachment" => "-",
                    "id_user_add" => $this->session->id_user
                );
                $id_harga_vendor = insertRow("harga_vendor",$data);
                $data = array(
                    "id_harga_vendor" => $id_harga_vendor,
                    "id_perusahaan" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "id_cp" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "harga_produk" => 1,
                    "vendor_price_rate" => 1,
                    "mata_uang" => "-",
                    "notes" => "-",
                    "attachment" => "-",
                    "metode_pengiriman" => "-",    
                    "id_user_add" => $this->session->id_user
                );
                $id_harga_shipping = insertRow("harga_shipping",$data);
                $data = array(
                    "id_request_item" => $id_request_item,
                    "id_perusahaan" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "id_cp" => -1, // klo data entry abaikan aja, cuman buat jalanin sistemnya
                    "harga_produk" => 1,
                    "vendor_price_rate" => 1,
                    "mata_uang" => "-",
                    "notes" => "-",
                    "attachment" => "-",
                    "metode_pengiriman" => "-",    
                    "id_user_add" => $this->session->id_user
                );
                $id_harga_courier = insertRow("harga_courier",$data);
                $data = array(
                    "id_submit_quotation" => $id_submit_quotation,
                    "id_request_item" => $id_request_item,
                    "nama_produk_leiter" => $category[$a]["nama_oc_item"],
                    "attachment" => "-",
                    "id_harga_vendor" => $id_harga_vendor[$a],
                    "id_harga_courier" => $id_harga_courier[$a],
                    "id_harga_shipping" => $id_harga_shipping[$a],
                    "item_amount" => $category[$a]["jumlah"],
                    "satuan_produk" => $category[$a]["satuan"],
                    "selling_price" => $category[$a]["final_selling_price"],
                    "margin_price" => "0%"
                );
                $id_quotation_item = insertRow("quotation_item",$data);
                $data = array(
                    "id_submit_oc" => $id_submit_oc,
                    "id_quotation_item" => $id_quotation_item, /*quotation barang 1*/
                    "nama_oc_item" => $category[$a]["nama_oc_item"], /*nama produk oc barang 1*/
                    "id_produk" => $category[$a]["id_produk"], 
                    "final_amount" => $category[$a]["jumlah"], /*3*/
                    "satuan_produk" => $category[$a]["satuan"], /*meter*/
                    "final_selling_price" => $category[$a]["final_selling_price"],
                    "status_oc_item" => 0
                );
                insertRow("order_confirmation_item",$data);
            }
            
            
            /*masukin metode pembayaran*/
            
            $data = array(
                "id_submit_oc" => $id_submit_oc,
                "persentase_pembayaran" => $input_data["persentase_pembayaran"],
                "nominal_pembayaran" => splitterMoney($input_data["nominal_pembayaran"],","),
                "trigger_pembayaran" => $input_data["trigger_pembayaran"],
                "status_bayar" => 1,
                "is_ada_transaksi" => $is_ada_transaksi,
                "persentase_pembayaran2" => $input_data["persentase_pembayaran2"],
                "nominal_pembayaran2" => splitterMoney($input_data["nominal_pembayaran2"],","),
                "trigger_pembayaran2" => $input_data["trigger_pembayaran2"],
                "status_bayar2" => 1,
                "is_ada_transaksi2" => $is_ada_transaksi2,
                "kurs" => $input_data["mata_uang_pembayaran"]
            );
            insertRow("order_confirmation_metode_pembayaran",$data);
            $data = array(
                "id_submit_quotation" => $id_submit_quotation,
                "persentase_pembayaran" => $input_data["persentase_pembayaran"],
                "nominal_pembayaran" => splitterMoney($input_data["nominal_pembayaran"],","),
                "trigger_pembayaran" => $input_data["trigger_pembayaran"],
                "status_bayar" => 1,
                "is_ada_transaksi" => $is_ada_transaksi,
                "persentase_pembayaran2" => $input_data["persentase_pembayaran2"],
                "nominal_pembayaran2" => splitterMoney($input_data["nominal_pembayaran2"],","),
                "trigger_pembayaran2" => $input_data["trigger_pembayaran2"],
                "status_bayar2" => 1,
                "is_ada_transaksi2" => $is_ada_transaksi2,
                "kurs" => $input_data["mata_uang_pembayaran"]
            );
            insertRow("quotation_metode_pembayaran",$data);
        }
        redirect("crm/oc/page/".$this->session->page);
    }   
    public function insertoc(){ //sudah di cek
        /*insert ke oc tanpa total_oc_price*/
        $data["oc"] = array(
            "id_submit_quotation" => $this->session->id_submit_quotation,
            "id_oc" => $this->input->post("id_oc"),
            "bulan_oc" => date("m"),
            "tahun_oc" => date("Y"),
            "no_oc" => $this->input->post("no_oc"),
            "no_po_customer" => $this->input->post("no_po_customer"),
            "tgl_po_customer" => $this->input->post("tgl_po_customer"),
            "total_oc_price" => splitterMoney($this->input->post("total_oc_price"),","),
            "up_cp" => $this->input->post("up_cp"),
            "durasi_pembayaran" => $this->input->post("durasi_pembayaran"),
            "durasi_pengiriman" => $this->input->post("durasi_pengiriman"),
            "metode_pengiriman" => $this->input->post("metode_pengiriman"),
            "franco" => $this->input->post("franco"),
            "alamat_perusahaan_oc" => $this->input->post("alamat_perusahaan_oc"),
            "id_user_add" => $this->session->id_user
        );
        if(in_array("",$data)){
            $this->session->set_flashdata("invalid","Terdapat form yang kosong");
            $report = "Your Input Before: ";
            foreach($data as $key => $value){
                $report .= $key." = ".$value."<br/>";
            }
            $this->session->set_flashdata("report",$report);
            redirect("crm/oc/create");
        }
        $id_submit_oc = getMaxId("order_confirmation","id_submit_oc",array());
        
        /*insert ke item oc*/
        $checks = $this->input->post("checks");
        
        if($checks != ""){
            $counter = 0;
            foreach($checks as $checked){
                $amount = $this->input->post("final_amount".$checked);
                if($amount == ""){
                    $this->session->set_flashdata("invalid","Mohon jumlah produk diisi");
                    redirect("crm/oc/create");
                }
                else{
                    $split = explode(" ",$amount);
                    if(count($split) == 1){
                        $split[1] = "-"; //yang satuan, ada chance dikosongin
                    } 
                }
                $nama_item_oc = $this->input->post("nama_oc_item".$checked);
                if($nama_item_oc == ""){
                    $nama_item_oc = "-";
                }
                $id_produk = $this->input->post("id_produk".$checked);
                if($id_produk == ""){
                    $id_produk = -1;
                }
                $data["items"][$counter] = array(
                    "id_submit_oc" => $id_submit_oc,
                    "id_quotation_item" => $checked, /*quotation barang 1*/
                    "nama_oc_item" => $nama_item_oc, /*nama produk oc barang 1*/
                    "final_amount" => $split[0], /*3*/
                    "satuan_produk" => $split[1], /*meter*/
                    "final_selling_price" =>splitterMoney($this->input->post("final_selling_price".$checked),","),
                    "id_produk" => $id_produk
                );
                if(in_array("",$data)){
                    $this->session->set_flashdata("invalid","Mohon mengisi produk dengan benar");
                    $report = "Your Input Before: ";
                    foreach($data as $key => $value){
                        $report .= $key." = ".$value."<br/>";
                    }
                    $this->session->set_flashdata("report",$report);
                    redirect("crm/oc/create");
                }
                $counter++;
                
            }
        }
        /*end masukin oc_item*/
        /*masukin metode pembayaran*/
        $is_ada_transaksi = 0;
        if($this->input->post("persentase_pembayaran") == 0){ //persentase DP 0
            $is_ada_transaksi = 1;
        }
        $is_ada_transaksi2 = 0;
        if($this->input->post("persentase_pembayaran2") == 0){ //persentase pelunasan 0
            $is_ada_transaksi2 = 1;
        }
        $data["metode_pembayaran"] = array(
            "id_submit_oc" => $id_submit_oc,
            "persentase_pembayaran" => $this->input->post("persentase_pembayaran"),
            "nominal_pembayaran" => splitterMoney($this->input->post("nominal_pembayaran"),","),
            "trigger_pembayaran" => $this->input->post("trigger_pembayaran"),
            "status_bayar" => "1",
            "is_ada_transaksi" => $is_ada_transaksi."",
            "persentase_pembayaran2" => $this->input->post("persentase_pembayaran2"),
            "nominal_pembayaran2" => splitterMoney($this->input->post("nominal_pembayaran2"),","),
            "trigger_pembayaran2" => $this->input->post("trigger_pembayaran2"),
            "status_bayar2" => "1",
            "is_ada_transaksi2" => $is_ada_transaksi2."",
            "kurs" => $this->input->post("mata_uang_pembayaran")
        );
        if(in_array("",$data)){
            $this->session->set_flashdata("invalid","Mohon mengisi metode pembayaran dengan benar");
            $report = "Your Input Before: ";
            foreach($data as $key => $value){
                $report .= $key." = ".$value."<br/>";
            }
            $this->session->set_flashdata("report",$report);
            redirect("crm/oc/create");
        }
        
        /*end metode pembayaran*/
        $this->Mdorder_confirmation->createOrderConfirmation($data["oc"],$data["items"],$data["metode_pembayaran"]);
        redirect("crm/oc/page/".$this->session->page);
    }   
    public function delete($id_submit_oc){ //sudah di cek
        $where = array(
            "id_submit_oc" => $id_submit_oc
        );
        $data = array(
            "status_aktif_oc" => 1
        );
        updateRow("order_confirmation",$data,$where);
        redirect("crm/oc/page/".$this->session->page);
    }
    public function accepted($id_submit_oc){
        $where = array(
            "id_submit_oc" => $id_submit_oc
        );
        $data = array(
            "status_oc" => 2
        );
        updateRow("order_confirmation",$data,$where);
        redirect("crm/oc/page/".$this->session->page);
    }
    function ocPdf($id_submit_oc){ //sudah di cek   
        $where=array(
            "id_submit_oc"=>$id_submit_oc,
        );

        $this->load->model('M_pdf_oc');
        $oc = $this->M_pdf_oc->selectOC($where);
        $perusahaan =$this->M_pdf_oc->selectPerusahaan($where);
        $barang = $this->M_pdf_oc->selectBarang($where);
        $metodebayar = $this->M_pdf_oc->selectMetodeBayar($where);

        $data=array(
            "order_confirmation"=>$oc,
            "perusahaan"=>$perusahaan,
            "barang"=>$barang,
            "metodebayar"=>$metodebayar,
        );
        $this->load->view('crm/oc/pdf_oc',$data);
    }
    /******** DATA TABLE SECTION *********8 */
    public function sort(){
        $this->session->order_by = $this->input->post("order_by");
        $this->session->order_direction = $this->input->post("order_direction");
        redirect("crm/oc/page/".$this->session->page);
    }
    public function search(){
        $search = $this->input->post("search");
        $this->session->search = $search;
        redirect("crm/oc/page/".$this->session->page);
    }
    public function page($i){
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
        
        $where = array(
            "id_user_add_oc" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_oc")) == 0){
            $where = array(
                "status_aktif_oc" => 0,
                "id_user_add_oc" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_oc")) == 0){
            $where = array(
                "status_aktif_oc" => 0
            );
        }
        $field = array(
            "id_submit_quotation","no_po_customer","no_oc","id_oc","bulan_oc","tahun_oc","id_submit_oc","tgl_po_customer","total_oc_price","nama_perusahaan","nama_cp","no_quotation"
        );
        if($this->session->search != ""){
            $or_like = array(
                "no_po_customer" => $this->session->search,
                "no_oc" => $this->session->search,
                "no_quotation" => $this->session->search,
                "nama_perusahaan" => $this->session->search,
                "nama_cp" => $this->session->search,
                "tgl_po_customer" => $this->session->search,
                "total_oc_price" => $this->session->search
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
        $result = $this->Mdorder_confirmation->getDataTable($where,$field,$or_like,$order_by,$direction,$limit,$offset);
        //$result = selectRow("order_detail",$where,$field,$limit,$offset,"tgl_po_customer","DESC");

        $data["oc"]= $result->result_array();
        for($a = 0; $a<count($data["oc"]);$a++){
            
            $where = array(
                "id_submit_oc" => $data["oc"][$a]["id_submit_oc"]
            );
            $field = array(
                "id_oc_item","nama_oc_item","final_amount_oc","satuan_produk_oc","final_selling_price_oc","status_oc_item"
            );
            $result = selectRow("order_item_detail",$where,$field);
            $data["oc"][$a]["oc_item"] = $result->result_array();

            $where = array(
                "id_submit_oc" => $data["oc"][$a]["id_submit_oc"]
            );
            $field = array(
                "persentase_pembayaran","nominal_pembayaran","trigger_pembayaran","status_bayar","is_ada_transaksi","persentase_pembayaran2","nominal_pembayaran2","trigger_pembayaran2","status_bayar2","is_ada_transaksi2","kurs"
            );
            $result = selectRow("order_confirmation_metode_pembayaran",$where,$field);
            $data["oc"][$a]["metode_pembayaran"] = $result->result_array();

            if($data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] == 1){
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] = "BEFORE ORDER DELIVERY";
            }
            else{
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] = "AFTER ORDER DELIVERY";
            }
            if($data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] == 1){
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] = "BEFORE ORDER DELIVERY";
            }
            else{
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] = "AFTER ORDER DELIVERY";
            }

        }
        /*pop up quotation*/
        $where = array(
            "status_quotation" => 2,
            "status_aktif_quotation" => 0
        );
        $field = array(
            "no_quotation","nama_perusahaan","nama_cp","id_submit_quotation"
        );
        $result = selectRow("order_detail",$where,$field);
        $data["quotation"] = $result->result_array();
        $data["search"] = array(
            "no_po_customer","no_oc","no_quotation","nama_perusahaan","nama_cp","tgl_po_customer","total_oc_price"
        );
        $data["search_print"] = array(
            "no po customer","no oc","no quotation","nama perusahaan","nama cp","tgl po customer","total oc price"
        );
        $data["jumlah_semua_data"] = getAmount("order_confirmation","id_submit_oc",array("status_aktif_oc" => 0));
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/oc/category-header");
        $this->load->view("crm/oc/category-body",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function removeFilter(){
        $this->session->unset_userdata("order_by");
        $this->session->unset_userdata("order_direction");
        $this->session->unset_userdata("search");
        redirect("crm/oc/page/".$this->session->page);
    }
}
?>