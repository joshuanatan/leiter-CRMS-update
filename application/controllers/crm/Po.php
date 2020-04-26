<?php
class Po extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdpo_core");
        $this->load->model("Mdorder_confirmation");
        $this->load->model("Mdpo_item");
        $this->load->library('Pdf_oc');
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
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome");
        $where = array(
            "id_user_add_po" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_po")) == 0){
            $where = array(
                "status_aktif_po" => 0,
                "id_user_add_po" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_po")) == 0){
            $where = array(
                "status_aktif_po" => 0,
            );
        }
        $field = array(
            "id_submit_po","no_po","id_supplier","id_shipper","shipping_method","total_supplier_payment","id_submit_oc","requirement_date","destination","date_po_core_add","id_cp_supplier","id_cp_shipper","shipping_term","mata_uang_pembayaran","nama_supplier_po","nama_shipper_po","nama_cp_shipper","nama_cp_supplier","nama_perusahaan","nama_cp","status_selesai_po"
        );
        $result = selectRow("po_detail",$where,$field);
        $data["purchase_order"] = $result->result_array();
        for($a = 0; $a<count($data["purchase_order"]); $a++){
            
            $where = array(
                "id_submit_po" => $data["purchase_order"][$a]["id_submit_po"]
            );
            $field = array(
                "nama_produk_vendor_po","harga_item_po","jumlah_item_po","satuan_item_po","id_oc_item","nama_oc_item"
            );
            $result = selectRow("po_item_detail",$where,$field);
            $data["purchase_order"][$a]["items"] = $result->result_array();
        }
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/category-body",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("crm/po/js/request-ajax");
        $this->load->view("crm/crm-close");
        $this->load->view("req/html-close");
    }
    
    public function create(){ //sudah di tes
        $data["maxId"] = getMaxId("po_core","id_po",array("bulan_po" => date("m"), "tahun_po" => date("Y"),"status_aktif_po" => 0));

        $where["list_oc"] = array(
            "status_aktif_oc" => 0
        );
        $field["list_oc"] = array(
            "id_submit_oc","id_submit_quotation","no_po_customer"
        );
        $result["list_oc"] = $this->Mdorder_confirmation->getListOc($where["list_oc"]);
        $data["list_oc"] = foreachMultipleResult($result["list_oc"],$field["list_oc"],$field["list_oc"]);
        for($a = 0; $a<count($data["list_oc"]); $a++){
            $id_submit_request = get1Value("quotation","id_request",array("id_submit_quotation" => $data["list_oc"][$a]["id_submit_quotation"]));
            $id_perusahaan = get1value("price_request","id_perusahaan",array("id_submit_request" => $id_submit_request));
            $data["list_oc"][$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan", array("id_perusahaan" => $id_perusahaan));
            $data["list_oc"][$a]["id_perusahaan"] = $id_perusahaan;
        }
        
        $field["perusahaan"] = array(
            "nama_perusahaan","id_perusahaan"
        );
        $where["supplier"] = array(
            "status_perusahaan" => 0,
            "peran_perusahaan" => "PRODUK"
        );
        $result["supplier"] = selectRow("perusahaan",$where["supplier"]);
        $data["supplier"] = foreachMultipleResult($result["supplier"],$field["perusahaan"],$field["perusahaan"]);
        $where["shipper"] = array(
            "status_perusahaan" => 0,
            "peran_perusahaan" => "SHIPPING"
        );
        $result["shipper"] = selectRow("perusahaan",$where["shipper"]);
        $data["shipper"] = foreachMultipleResult($result["shipper"],$field["perusahaan"],$field["perusahaan"]);
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/add-po",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function insertPo(){ //sudah dites
        $data = array(
            "id_submit_oc" => $this->input->post("id_submit_oc"),
            "id_po" => $this->input->post("id_po"),
            "bulan_po" => date("m"),
            "tahun_po" => date("Y"),
            "no_po" => $this->input->post("no_po"),
            "id_supplier" => $this->input->post("id_supplier"),
            "id_cp_supplier" => $this->input->post("id_cp_supplier"),
            "id_shipper" => $this->input->post("id_shipper"),
            "id_cp_shipper" => $this->input->post("id_cp_shipper"),
            "shipping_method" => $this->input->post("shipping_method"),
            "shipping_term" => $this->input->post("shipping_term"),
            "requirement_date" => $this->input->post("requirement_date"),
            "destination" => $this->input->post("destination"),
            "total_supplier_payment" => 0,
            "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
            "id_user_add" => $this->session->id_user
        );
        $id_submit_po = insertRow("po_core",$data);
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $checked){ /*bkin PO dari yang di centang aja*/
                $jumlah = $this->input->post("jumlah_produk".$checked);
                $split = explode(" ",$jumlah);
                $data = array(
                    "id_submit_po" => $id_submit_po,
                    "nama_produk_vendor" => $this->input->post("nama_produk_vendor".$checked),
                    "harga_item" => splitterMoney($this->input->post("harga_satuan_produk".$checked),","),
                    "jumlah_item" => $split[0],
                    "satuan_item" => $split[1],
                    "id_oc_item" => $this->input->post("id_oc_item".$checked)
                );
                insertRow("po_item",$data);
            }
        }
        redirect("crm/po");
    }
    public function edit($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $field = array(
            "id_submit_oc","id_submit_po","no_po","id_supplier","id_cp_supplier","id_shipper","id_cp_shipper","shipping_method","shipping_term","requirement_date","destination","nama_supplier_po","alamat_supplier_po","notelp_supplier_po","nofax_supplier_po","nama_shipper_po","alamat_shipper_po","notelp_shipper_po","nofax_shipper_po","no_po_customer","nama_perusahaan","nama_cp","nama_cp_shipper","nama_cp_supplier","mata_uang_pembayaran","id_po","bulan_po","tahun_po","date_po_core_add"      
        );
        $result = selectRow("po_detail", $where,$field);
        $data["po_core"] = $result->result_array();
        
        
        /*load list supplier*/
        
        $field = array(
            "nama_perusahaan","id_perusahaan","peran_perusahaan"
        );
        $where = array(
            "status_perusahaan" => 0
        );
        $result = selectRow("perusahaan",$where,$field);
        $data["supplier"] = $result->result_array();
        /*end load list supplier*/

        $field = array(
            "nama_cp","id_cp"
        );
        /*load list supplier*/
        $where = array(
            "status_cp" => 0
        );
        $result = selectRow("contact_person",$where,$field);
        $data["contact_person"] = $result->result_array();
        /*end load list supplier*/

        /*load item dari oc*/
        $field = array(
            "nama_oc_item","final_selling_price_oc","final_amount_oc","satuan_produk_oc","order_item_detail.id_oc_item","jumlah_item","satuan_item","po_item.nama_produk_vendor","harga_item","id_po_item"
        );
        $where = array(
            "status_oc_item" => 0,
        );
        $result = $this->Mdpo_item->getPoItem($data["po_core"][0]["id_submit_oc"],$id_submit_po,$where,$field);
        $data["items"] = $result->result_array();

        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/edit-po",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function editPo(){ //sudah di cek
        $where["main"] = array(
            "id_submit_po" => $this->input->post("id_submit_po")
        );
        $data["po_core"] = array(
            "id_po" => $this->input->post("id_po"),
            "bulan_po" => $this->input->post("bulan_po"),
            "tahun_po" => $this->input->post("tahun_po"),
            "no_po" => $this->input->post("no_po"),
            "id_supplier" => $this->input->post("id_supplier"),
            "id_cp_supplier" => $this->input->post("id_cp_supplier"),
            "id_shipper" => $this->input->post("id_shipper"),
            "id_cp_shipper" => $this->input->post("id_cp_shipper"),
            "shipping_method" => $this->input->post("shipping_method"),
            "shipping_term" => $this->input->post("shipping_term"),
            "requirement_date" => $this->input->post("requirement_date"), 
            "destination" => $this->input->post("destination"),
            "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
            "date_po_core_add" => $this->input->post("date_po_core_add")
        );
        updateRow("po_core",$data["po_core"],$where["main"]);
        
        /*delete po item yang sudah ada*/
        deleteRow("po_item",$where["main"]);
        /* end delete po item yang sudah ada*/

        /*ngambil yang di checks*/
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $checked){ /*ngambil row yang di check*/
                $jumlah = $this->input->post("jumlah_produk".$checked);
                $split = explode(" ",$jumlah);
                if(count($split) == 1){
                    $split[1] = "-";
                }
                $data = array(
                    "id_submit_po" => $this->input->post("id_submit_po"),
                    "id_oc_item" => $checked,
                    "nama_produk_vendor" => $this->input->post("nama_produk_vendor".$checked),
                    "harga_item" => splitterMoney($this->input->post("harga_satuan_produk".$checked),","),
                    "jumlah_item" => $split[0],
                    "satuan_item" => $split[1],
                );
                insertRow("po_item",$data);
                /*masukin po item*/
            }   
        }
        $delete = $this->input->post("delete");
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_po_item" => $deleted
                );
                deleteRow("po_item",$where);
            }
        }
        redirect("crm/po");
    }
    function poPdf($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po,
        );
        $this->load->model('M_pdf_po');
        $purchaseorder = $this->M_pdf_po->selectPo($where);
        $vendorr= $this->M_pdf_po->selectVendor($where);
        $custt= $this->M_pdf_po->selectShipper($where);
        $barangg= $this->M_pdf_po->selectBarang($where);
        $data = array(
            "purchaseorder"=>$purchaseorder,
            "vendor"=>$vendorr,
            "customer"=>$custt,
            "barang"=>$barangg,
            "mata_uang" => get1Value("po_core","mata_uang_pembayaran",array("id_submit_po" => $id_submit_po)),
        );
        $this->load->view('crm/po/pdf_po',$data);
    }
    public function delete($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $data = array(
            "status_aktif_po" => 1
        );
        updateRow("po_core",$data,$where);
        redirect("crm/po");
    }
    public function done($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $data = array(
            "status_selesai_po" => 0
        );
        updateRow("po_core",$data,$where);
        redirect("crm/po");
    }
    public function stock(){
        if($this->session->id_user == "") redirect("login/welcome");
        $where = array(
            "id_user_add_po" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_po")) == 0){
            $where = array(
                //"status_aktif_po" => 0, //udah ada di view, mau diliat apakah efektif apa enggak
                //"id_submit_oc" => -1, //udah ada di view, mau diliat apakah efektif apa enggak
                "id_user_add_po" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_po")) == 0){
            $where = array(
                //"status_aktif_po" => 0,
                "id_submit_oc" => -1,
            );
        }
        $field = array(
            "id_submit_po","no_po","id_supplier","id_shipper","shipping_method","total_supplier_payment","id_submit_oc","requirement_date","destination","date_po_core_add","id_cp_supplier","id_cp_shipper","shipping_term","mata_uang_pembayaran","nama_supplier","nama_shipper","nama_cp_shipper","nama_cp_supplier","status_selesai_po"
        );
        $result = selectRow("po_stock",$where,$field);
        $data["purchase_order"] = $result->result_array();
        for($a = 0; $a<count($data["purchase_order"]); $a++){
            
            $where = array(
                "id_submit_po" => $data["purchase_order"][$a]["id_submit_po"]
            );
            $field = array(
                "nama_produk_vendor","harga_item","jumlah_item","satuan_item","id_produk","deskripsi_produk"
            );
            $result = selectRow("po_stock_item_detail",$where,$field);
            $data["purchase_order"][$a]["items"] = $result->result_array();
        }
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/po-stock",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function createPoStock(){
        $data["maxId"] = getMaxId("po_core","id_po",array("bulan_po" => date("m"), "tahun_po" => date("Y"),"status_aktif_po" => 0));

        $field["perusahaan"] = array(
            "nama_perusahaan","id_perusahaan"
        );
        $where["supplier"] = array(
            "status_perusahaan" => 0,
            "peran_perusahaan" => "PRODUK"
        );
        $result["supplier"] = selectRow("perusahaan",$where["supplier"],$field["perusahaan"]);
        $data["supplier"] = $result["supplier"]->result_array();

        $where["shipper"] = array(
            "status_perusahaan" => 0,
            "peran_perusahaan" => "SHIPPING"
        );
        $result["shipper"] = selectRow("perusahaan",$where["shipper"],$field["perusahaan"]);
        $data["shipper"] = $result["shipper"]->result_array();
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/add-po-stock",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function insertPoStock(){
        $data = array(
            "id_submit_oc" => -1,
            "id_po" => getMaxId("po_core","id_po",array("bulan_po" => date("m"), "tahun_po" => date("Y"),"status_aktif_po" => 0)), //fail 1 try
            "bulan_po" => date("m"),
            "tahun_po" => date("Y"),
            "no_po" => $this->input->post("no_po"),
            "id_supplier" => $this->input->post("id_supplier"),
            "id_cp_supplier" => $this->input->post("id_cp_supplier"),
            "id_shipper" => $this->input->post("id_shipper"),
            "id_cp_shipper" => $this->input->post("id_cp_shipper"),
            "shipping_method" => $this->input->post("shipping_method"),
            "shipping_term" => $this->input->post("shipping_term"),
            "requirement_date" => $this->input->post("requirement_date"),
            "destination" => $this->input->post("destination"),
            "total_supplier_payment" => 0,
            "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
            "id_user_add" => $this->session->id_user
        );
        $id_submit_po = insertRow("po_core",$data);
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $checked){ /*bkin PO dari yang di centang aja*/
                $jumlah = $this->input->post("jumlah_produk".$checked);
                $split = explode(" ",$jumlah);
                $data = array(
                    "id_submit_po" => $id_submit_po,
                    "nama_produk_vendor" => $this->input->post("nama_produk_vendor".$checked),
                    "harga_item" => splitterMoney($this->input->post("harga_satuan_produk".$checked),","),
                    "jumlah_item" => $split[0],
                    "satuan_item" => $split[1],
                    "id_produk" => $this->input->post("id_produk_item".$checked)
                );
                insertRow("po_stock_item",$data);
            }
        }
        redirect("crm/po/stock");
    }
    public function editPoStock($id_submit_po){
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $field = array(
            "id_submit_po","no_po","id_supplier","id_cp_supplier","id_shipper","id_cp_shipper","shipping_method","shipping_term","requirement_date","destination","nama_supplier","alamat_supplier","notelp_supplier","nofax_supplier","nama_shipper","alamat_shipper","notelp_shipper","nofax_shipper","nama_cp_shipper","nama_cp_supplier","mata_uang_pembayaran"      
        );
        $result = selectRow("po_stock", $where,$field);
        $data["po_core"] = $result->result_array();
        
        
        /*load list supplier*/
        
        $field = array(
            "nama_perusahaan","id_perusahaan","peran_perusahaan"
        );
        $where = array(
            "status_perusahaan" => 0
        );
        $result = selectRow("perusahaan",$where,$field);
        $data["supplier"] = $result->result_array();
        /*end load list supplier*/

        $field = array(
            "nama_cp","id_cp"
        );
        /*load list supplier*/
        $where = array(
            "status_cp" => 0
        );
        $result = selectRow("contact_person",$where,$field);
        $data["contact_person"] = $result->result_array();
        /*end load list supplier*/

        /*load item dari oc*/
        $field = array(
           "id_po_item","id_produk","nama_produk_vendor","harga_item","jumlah_item","satuan_item","deskripsi_produk","satuan_produk"
        );
        $where = array(
            "id_submit_po" => $data["po_core"][0]["id_submit_po"],
        );
        $result = selectRow("po_stock_item_detail",$where,$field);
        $data["items"] = $result->result_array();

        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/po/category-header");
        $this->load->view("crm/po/edit-po-stock",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function updatePoStock(){
        $where = array(
            "id_submit_po" => $this->input->post("id_submit_po")
        );
        $data = array(
            "id_supplier" => $this->input->post("id_supplier"),
            "id_cp_supplier" => $this->input->post("id_cp_supplier"),
            "id_shipper" => $this->input->post("id_shipper"),
            "id_cp_shipper" => $this->input->post("id_cp_shipper"),
            "shipping_method" => $this->input->post("shipping_method"),
            "shipping_term" => $this->input->post("shipping_term"),
            "requirement_date" => $this->input->post("requirement_date"),
            "destination" => $this->input->post("destination"),
            "mata_uang_pembayaran" => $this->input->post("mata_uang_pembayaran"),
        );
        $id_submit_po = updateRow("po_core",$data,$where);
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $checked){ /*bkin PO dari yang di centang aja*/
                if($this->input->post("id_po_item".$checked) != ""){
                    $where = array(
                        "id_po_item" => $this->input->post("id_po_item".$checked)
                    );
                    $jumlah = $this->input->post("jumlah_produk".$checked);
                    $split = explode(" ",$jumlah);
                    $data = array(
                        "nama_produk_vendor" => $this->input->post("nama_produk_vendor".$checked),
                        "harga_item" => splitterMoney($this->input->post("harga_satuan_produk".$checked),","),
                        "jumlah_item" => $split[0],
                        "satuan_item" => $split[1],
                        "id_produk" => $this->input->post("id_produk_item".$checked)
                    );
                    updateRow("po_stock_item",$data,$where);
                }
                else{
                    $jumlah = $this->input->post("jumlah_produk".$checked);
                    $split = explode(" ",$jumlah);
                    $data = array(
                        "id_submit_po" => $this->input->post("id_submit_po"),
                        "nama_produk_vendor" => $this->input->post("nama_produk_vendor".$checked),
                        "harga_item" => splitterMoney($this->input->post("harga_satuan_produk".$checked),","),
                        "jumlah_item" => $split[0],
                        "satuan_item" => $split[1],
                        "id_produk" => $this->input->post("id_produk_item".$checked)
                    );
                    insertRow("po_stock_item",$data);
                }
                
            }
        }
        $delete = $this->input->post("delete");
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_po_item" => $deleted
                );
                deleteRow("po_stock_item",$where);
            }
        }
        redirect("crm/po/stock");
    }
    public function deletePoStock($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $data = array(
            "status_aktif_po" => 1
        );
        updateRow("po_core",$data,$where);
        redirect("crm/po/stock");
    }
    public function donePoStock($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po
        );
        $data = array(
            "status_selesai_po" => 0
        );
        updateRow("po_core",$data,$where);
        redirect("crm/po/stock");
    }
    function poStockPdf($id_submit_po){ //sudah di cek
        $where = array(
            "id_submit_po" => $id_submit_po,
        );
        $this->load->model('M_pdf_po');
        $purchaseorder = $this->M_pdf_po->selectPo($where);
        $vendorr= $this->M_pdf_po->selectVendor($where);
        $custt= $this->M_pdf_po->selectShipper($where);
        $barangg= $this->M_pdf_po->selectStockPoItem($where);
        $data = array(
            "purchaseorder"=>$purchaseorder,
            "vendor"=>$vendorr,
            "customer"=>$custt,
            "barang"=>$barangg,
            "mata_uang" => get1Value("po_core","mata_uang_pembayaran",array("id_submit_po" => $id_submit_po)),
        );
        $this->load->view('crm/po/pdf_po_stock',$data);
    }

}
?>