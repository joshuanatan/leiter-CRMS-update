<?php
class Request extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdprice_request");
        $this->load->model("Mdperusahaan");
        $this->load->model("Mdproduk");
        $this->load->model("Mdprice_request_item"); 
        $this->load->model("Mdcontact_person"); 
    }
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
        $this->load->view("crm/request/js/request-ajax");
        $this->load->view("crm/crm-close");
        $this->load->view("req/html-close");
    }
    public function index(){ 
        $this->session->page = 1;
        if($this->session->id_user == "") redirect("login/welcome");//sudah di cek
        $this->removeFilter();
        redirect("crm/request/page/".$this->session->page);
    }
    public function add(){ //sudah di cek
        $where = array(
            "customer" => array(
                "peran_perusahaan" => "CUSTOMER",
            ),
            "maxId" => array(
                "bulan_request" => date("m"),
                "tahun_request" => date("Y"),
                "status_aktif_request" => 0
            )
        );
        $field = array(
            "customer" => array(
                "id_perusahaan", "nama_perusahaan"
            )
        );
        $print = array(
            "customer" => array(
                "id_perusahaan","nama_perusahaan"
            )
        );
        $result["customer"] = $this->Mdperusahaan->getListPerusahaan($where["customer"]);
        $data = array(
            "maxId" => getMaxId("price_request","id_request", $where["maxId"]),
            "customer" => foreachMultipleResult($result["customer"],$field["customer"],$print["customer"])
        );

        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/request/category-header");
        $this->load->view("crm/request/add-request",$data);
        $this->load->view("crm/content-close");
        $this->load->view("req/script");
        $this->close();
    }
    public function edit($id_submit_request){ //sudah di cek
        $where = array(
            "price_request" => array(
                "id_submit_request" => $id_submit_request
            ),
            "perusahaan" => array(
                "status_perusahaan" => 0,
                "peran_perusahaan" => "CUSTOMER"
            ),
        );
        $field = array(
            "price_request" => array(
                "id_request","no_request","tgl_dateline_request","id_perusahaan","id_cp","franco"
            ),
            "perusahaan" => array(
                "id_perusahaan","nama_perusahaan"
            ),
            "cp" => array(
                "id_cp","nama_cp","jk_cp"
            ),
            "detail_cp" => array(
                "email_cp", "nohp_cp"
            ),
            "items" => array(
                "nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
            )
        );
        $print = array(
            "price_request" => array(
                "id_request","no_request","tgl_dateline_request","id_perusahaan","id_cp","franco"
            ),
            "perusahaan" => array(
                "id_perusahaan","nama_perusahaan"
            ),
            "cp" => array(
                "id_cp","nama_cp","jk_cp"
            ),
            "detail_cp" => array(
                "email_cp", "nohp_cp"
            ),
            "items" => array(
                "nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
            )
        );
        
        /*load detail price request*/
        $result = selectRow("price_request",$where["price_request"]);
        $data["price_request"] = foreachResult($result,$field["price_request"],$print["price_request"]);
        /*end load detail price request*/

        /*load dropdown perusahaan*/
        $result = $this->Mdperusahaan->getListPerusahaan($where["perusahaan"]);
        $data["perusahaan"] = foreachMultipleResult($result,$field["perusahaan"],$print["perusahaan"]); /*list customer*/
        /*end load dropdown perusahaan*/

        /*load dropdown cp dari perusahaan terkait*/
        $where["cp"] = array(
            "id_perusahaan" => $data["price_request"]["id_perusahaan"],
            "status_cp" => 0
        );
        $result = $this->Mdcontact_person->getListCp($where["cp"]);
        $data["cp"] = foreachMultipleResult($result,$field["cp"],$print["cp"]); /*list cp*/
        /*end load dropdown cp*/
        
        /*load detail cp dari cp terkait*/
        $where["detail_cp"] = array(
            "id_cp" => $data["price_request"]["id_cp"]
        );
        $result = selectRow("contact_person",$where["detail_cp"]);
        $data["detail_cp"] = foreachResult($result,$field["detail_cp"],$print["detail_cp"]);
        /*end load detail cp dari cp terkait */

        /*load list item yang sudah tersubmit*/
        $where["items"] = array(
            "id_submit_request" => $id_submit_request
        );
        $result = selectRow("price_request_item",$where["items"]);
        $data["items"] = foreachMultipleResult($result,$field["items"],$print["items"]);
        $data["id_submit_request"] = $id_submit_request;
        /*end load list item yang sudah tersubmit */
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/request/category-header");
        $this->load->view("crm/request/detail-request",$data);
        $this->load->view("crm/content-close");
        $this->load->view("req/script");
        $this->close();
    }
    public function insert(){ //sudah di cek
        /*insert price_request*/
        $data = array(
            "id_request" => $this->input->post("id_request"),
            "bulan_request" => date("m"),
            "tahun_request" => date("Y"),
            "no_request" => $this->input->post("no_request"),
            "id_perusahaan" => $this->input->post("id_perusahaan"),
            "id_cp" => $this->input->post("id_cp"),
            "franco" => $this->input->post("franco"),
            "untuk_stock" => '1',
            "tgl_dateline_request" => $this->input->post("tgl_dateline_request"),
            "status_request" => '0' , //jatoh disini
            "id_user_add" => $this->session->id_user,
            "date_request_add" => date("Y-m-d H:i:s"),
            "date_request_edit" => date("Y-m-d H:i:s")
        );
        if(in_array("",$data)){ //kalau ada data kosong
            $this->session->set_flashdata("invalid","Data form tidak lengkap, mohon diisi dengan hati-hati");
            //print_r($data);
            redirect("crm/request/add");
        }
        if($this->session->id_user == ""){ //kalau session ga ada
            redirect("welcome");
        }
        $checks = $this->input->post("checks");
        if($checks == ""){ //kalau ga ada yang di check
            $this->session->set_flashdata("invalid","Item tidak diisi, tolong diisi dan jangan lupa di centang");
            redirect("crm/request/add");
        }

        $id_submit_request = insertRow("price_request",$data);
        /*end price_request*/

         //ngambil yang di centang
        if(count($checks) != 0){ //kalau ada barang yang disubmit
            $config['upload_path']          = './assets/rfq/';
            $config['allowed_types']        = 'docx|jpeg|jpg|pdf|gif|png|xls|xlsx|doc';

            $this->load->library('upload', $config);
        }
        foreach($checks as $a){ //mengambil barang-barang yang di check di depan berdasarkan centang
            $check_data = array(
                "jumlah" => $this->input->post("jumlah_produk".$a),
                "nama_produk" => $this->input->post("item".$a),
                "notes_produk" => $this->input->post("notes".$a),
            );
            if($check_data["jumlah"] == ""){ //kalau kosong aja
                $check_data["jumlah"] = "0 -"; 
            }
            if($check_data["nama_produk"] == ""){ //kalau kosong aja
                $check_data["nama_produk"] = "-";
            }
            if($check_data["notes_produk"] == ""){ //kalau kosong aja
                $check_data["notes_produk"] = "-";
            }

            $split = explode(" ",$check_data["jumlah"]);
            if(count($split) == 1){ //kalau diinputnya jumlah doang
                $split[1] = "-";
            }
            if($this->upload->do_upload("attachment".$a)){
                $report = $this->upload->data();
                $data = array(
                    "id_submit_request" => $id_submit_request,
                    "nama_produk" => $check_data["nama_produk"],
                    "jumlah_produk" => $split[0],
                    "satuan_produk" => $split[1],
                    "notes_produk" => $check_data["notes_produk"],
                    "file" =>$report["file_name"],
                    "id_user_add" => $this->session->id_user
                );
            }
            else{
                $report = array('upload_data' => $this->upload->display_errors());
                $data = array(
                    "id_submit_request" => get1Value("price_request","id_submit_request", array("no_request" => $this->input->post("no_request"))),
                    "nama_produk" => $check_data["nama_produk"],
                    "jumlah_produk" => $split[0],
                    "satuan_produk" => $split[1],
                    "notes_produk" => $check_data["notes_produk"],
                    "file" =>"-",
                    "id_user_add" => $this->session->id_user
                );
            }
            insertRow("price_request_item",$data);
        }
        redirect("crm/request/page/".$this->session->page);
    }
    public function update(){ //sudah di cek
        $where = array(            
            "id_submit_request" => $this->input->post("id_submit_request")
        );
        if(in_array("",$where)){
            $this->input->set_flashdata("invalid","ID Request tidak ada");
            redirect("crm/request/edit/".$where["id_submit_request"]);
        }
        $data = array(
            "tgl_dateline_request" => $this->input->post("tgl_dateline_request"),
            "id_perusahaan" => $this->input->post("id_perusahaan"),
            "id_cp" => $this->input->post("id_cp"),
            "franco" => $this->input->post("franco"),
            "id_user_edit" => $this->session->id_user,
            "date_request_edit" => date("Y-m-d H:i:s")
        );
        if(in_array("",$data)){
            $this->input->set_flashdata("invalid","Data ada yang belum lengkap");
            redirect("crm/request/edit/".$where["id_submit_request"]);
        }
        updateRow("price_request",$data,$where);

        deleteRow("price_request_item",$where);

        $checks_ordered = $this->input->post("ordered_checks");
        $config['upload_path']          = './assets/rfq/';
        $config['allowed_types']        = 'docx|jpeg|jpg|pdf|gif|png|xls|xlsx|doc';

        $this->load->library('upload', $config);
    
        if($checks_ordered != "" && count($checks_ordered) != 0){
            
            foreach($checks_ordered as $a){
                $check_data = array(
                    "jumlah" => $this->input->post("ordered_amount".$a),
                    "nama_produk" => $this->input->post("ordered_nama".$a),
                    "notes_produk" => $this->input->post("ordered_notes".$a),
                );
                if($check_data["jumlah"] == ""){ //kalau kosong aja
                    $check_data["jumlah"] = "0 -"; 
                }
                if($check_data["nama_produk"] == ""){ //kalau kosong aja
                    $check_data["nama_produk"] = "-";
                }
                if($check_data["notes_produk"] == ""){ //kalau kosong aja
                    $check_data["notes_produk"] = "-";
                }
                $split = explode(" ",$check_data["jumlah"]);
                if(count($split) == 1){ //kalau diinputnya jumlah doang
                    $split[1] = "-";
                }
                /*kalau dia centang dan upload file baru*/
                if($this->upload->do_upload("ordered_new_attachment".$a)){ 
                    $report = $this->upload->data();
                    $data = array(
                        "id_submit_request" => $where["id_submit_request"],
                        "nama_produk" => $check_data["nama_produk"],
                        "jumlah_produk" => $split[0], 
                        "satuan_produk" => $split[1], 
                        "notes_produk" => $check_data["notes_produk"],
                        "file" =>$report["file_name"],
                        "id_user_add" => $this->session->id_user
                    );
                }
                /*kalau dia centang tapi tidak uplaod file baru*/
                else{
                    $data = array(
                        "id_submit_request" => $where["id_submit_request"],
                        "nama_produk" => $check_data["nama_produk"],
                        "jumlah_produk" => $split[0], 
                        "satuan_produk" => $split[1], 
                        "notes_produk" => $check_data["notes_produk"],
                        "file" => "-",
                        "id_user_add" => $this->session->id_user
                    );
                }
                insertRow("price_request_item",$data);
                
            }
        }
        /*barang baru yang di centang*/
        $checks = $this->input->post("checks");
        
        if($checks != "" && count($checks) != 0){
            foreach($checks as $a){
                $check_data = array(
                    "jumlah" => $this->input->post("jumlah_produk".$a),
                    "nama_produk" => $this->input->post("item".$a),
                    "notes_produk" => $this->input->post("notes".$a),
                );
                if($check_data["jumlah"] == ""){ //kalau kosong aja
                    $check_data["jumlah"] = "0 -"; 
                }
                if($check_data["nama_produk"] == ""){ //kalau kosong aja
                    $check_data["nama_produk"] = "-";
                }
                if($check_data["notes_produk"] == ""){ //kalau kosong aja
                    $check_data["notes_produk"] = "-";
                }
                $split = explode(" ",$check_data["jumlah"]);
                if(count($split) == 1){ //kalau diinputnya jumlah doang
                    $split[1] = "-";
                }
                /*yang dicentang, upload file*/
                if($this->upload->do_upload("attachment".$a)){
                    $report = $this->upload->data();
                    $data = array(
                        "id_submit_request" => $where["id_submit_request"],
                        "nama_produk" => $check_data["nama_produk"],
                        "jumlah_produk" => $split[0], 
                        "satuan_produk" => $split[1], 
                        "notes_produk" => $check_data["notes_produk"],
                        "file" =>$report["file_name"],
                        "id_user_add" => $this->session->id_user
                    );
                }
                /*yang dicentang, tidak upload*/
                else{
                    $data = array(
                        "id_submit_request" => $where["id_submit_request"],
                        "nama_produk" => $check_data["nama_produk"],
                        "jumlah_produk" => $split[0], 
                        "satuan_produk" => $split[1], 
                        "notes_produk" => $check_data["notes_produk"],
                        "file" =>"-",
                        "id_user_add" => $this->session->id_user
                    );
                }
                insertRow("price_request_item",$data);
            }
        }
        redirect("crm/request/page/".$this->session->page);
    }
    public function delete($id_submit_request){ //sudah di cek
        $where = array(
            "id_submit_request" => $id_submit_request
        );
        $data = array(
            "status_aktif_request" => 1
        );
        updateRow("price_request",$data,$where);
        redirect("crm/request/page/".$this->session->page);
    }
    public function confirm($id_submit_request){ //sudah di cek
        $where = array(
            "id_submit_request" => $id_submit_request
        );
        $data = array(
            "status_request" => 3
        );
        updateRow("price_request",$data,$where);
        redirect("crm/request/page/".$this->session->page);
    }
    public function insertNewCustomer(){ //sudah di cek
        $data = array(
            "nama_perusahaan" => $this->input->post("add_nama_customer"),
            "jenis_perusahaan" => $this->input->post("add_segment_customer"),
            "alamat_perusahaan" => $this->input->post("add_address_customer"),
            "alamat_pengiriman" => $this->input->post("add_pengiriman_customer"),
            "permanent" => 1,
            "peran_perusahaan" => "CUSTOMER"
        );
        $id_perusahaan = insertRow("perusahaan",$data);
        $data = array(
            "id_perusahaan" => $id_perusahaan,
            "nama_cp" => $this->input->post("add_pic"),
            "email_cp" =>  $this->input->post("add_email_pic"),
            "jk_cp" =>  $this->input->post("add_jk_pic"),
            "nohp_cp" =>  $this->input->post("add_phone_pic")
        );
        insertRow("contact_person",$data);
        redirect("crm/request/add");
    }
    /******** DATA TABLE SECTION *********8 */
    public function sort(){
        $this->session->order_by = $this->input->post("order_by");
        $this->session->order_direction = $this->input->post("order_direction");
        redirect("crm/request/page/".$this->session->page);
    }
    public function search(){
        $search = $this->input->post("search");
        $this->session->search = $search;
        redirect("crm/request/page/".$this->session->page);
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
            "no_request","franco","tgl_dateline_request","date_request_edit","nama_perusahaan","nama_cp",
        );
        $data["search_print"] = array(
            "no request","franco","tgl dateline request","tanggal edit","nama perusahaan","nama cp",
        );
        /*end page data*/

        /*form condition*/
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
        /*end form condition*/

        /*ganti bawah ini*/
        $where = array(
            "id_user_add_request" => "-999"
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_rfq")) == 0){
            $where = array(
                "order_detail.status_aktif_request" => 0,
                "id_user_add_request" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_rfq")) == 0){
            $where = array(
                "order_detail.status_aktif_request" => 0,
                
            );
        }
        $field = array(
            "id_request","no_request","id_perusahaan","id_cp","franco","bulan_request","tahun_request","status_request","tgl_dateline_request","id_submit_request","date_request_edit","nama_perusahaan","nama_cp"
        );
        $group_by = array(
            "id_submit_request"
        );
        $result = $this->Mdprice_request->getDataTable($where,$field,$or_like,$order_by,$direction,$limit,$offset,$group_by);
        $data["request"] = $result->result_array();

        
        for($a = 0; $a<count($data["request"]); $a++){ 

            $data["request"][$a]["jumlah"] = getAmount("price_request_item","id_request_item",array("id_submit_request" => $data["request"][$a]["id_submit_request"],"status_request_item" => 0));

            $where = array(
                "id_submit_request" => $data["request"][$a]["id_submit_request"]
            );
            $field = array(
                "nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
            );
            $result = selectRow("price_request_item",$where,$field);
            $data["request"][$a]["items"] = $result->result_array();
        }
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/request/category-header");
        $this->load->view("crm/request/category-body",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function removeFilter(){
        $this->session->unset_userdata("order_by");
        $this->session->unset_userdata("order_direction");
        $this->session->unset_userdata("search");
        redirect("crm/request/page/".$this->session->page);
    }
}
?>