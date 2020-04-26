<?php
class Vendor extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdprice_request");
        $this->load->model("Mdprice_request_item");
        $this->load->model("Mdproduk_vendor");
        $this->load->model("Mdharga_vendor");
        $this->load->model("Mdcontact_person");
        $this->load->model("Mdmetode_pengiriman_shipping");
        $this->load->model("Mdperusahaan");
        $this->load->model("Mdvariable_shipping_price");
        $this->load->model("Mdvariable_courier_price");
        $this->load->model("Mdmata_uang");
    }
    /*default function*/
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
        $this->load->view("plugin/jqtabledit/jqtabledit-js");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("crm/vendor-deal/js/dynamic-form-js");
        $this->load->view("crm/crm-close");
        $this->load->view("req/html-close");
    }
    /*page*/
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome"); //sudah di cek
        $where = array(
            "request" => array(
                "price_request.status_request" => 1
            )
        );
        $field = array(
            "request" => array(
                "no_request","id_perusahaan","id_cp","id_request","bulan_request","tahun_request","untuk_stock","id_submit_request"
            ),
            "request_item" => array(
                "nama_produk","id_request_item"
            )
        );
        $print = array(
            "request" => array(
                "no_request","id_perusahaan","id_cp","id_request","bulan_request","tahun_request","untuk_stock","id_submit_request"
            ),
            "request_item" => array(
                "nama_produk","id_request_item"
            )
        );    
        $result["request"] = $this->Mdprice_request->getListPriceRequest($where["request"]);
        $data["request"] = foreachMultipleResult($result["request"],$field["request"],$print["request"]);
        for($a = 0; $a<count($data["request"]);$a++){
            $data["request"][$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data["request"][$a]["id_perusahaan"]));

            $data["request"][$a]["nama_cp"] = get1Value("contact_person","nama_cp",array("id_cp" => $data["request"][$a]["id_cp"]));
            
            $where["request_item"] = array(
                "id_submit_request" => $data["request"][$a]["id_submit_request"]
            );
            $result["request_item"] = selectRow("price_request_item",$where["request_item"]); /*ngambil request item dengan id_submit_request terkait*/
            $data["request"][$a]["request_item"] = foreachMultipleResult($result["request_item"],$field["request_item"],$print["request_item"]); /*request item dalam 1 request*/

            for($items = 0; $items<count($data["request"][$a]["request_item"]); $items++){ /*jalanin setiap request item*/
                /*baru ngecek status tiap item*/

                /*kodingan di bawah ini masih hampir bener, tolong di cek, mau ujian. targetnya itu buat nyari tau tiap item apakah sudah semua apa belum*/
                $data["request"][$a]["request_item"][$items]["jumlahHargaVendor"] = $this->Mdharga_vendor->getListHargaVendor(array("price_request_item.id_request_item" => $data["request"][$a]["request_item"][$items]["id_request_item"]))->num_rows();

                $data["request"][$a]["request_item"][$items]["jumlahHargaCourier"] = $this->Mdharga_vendor->getListHargaCourier(array("price_request_item.id_request_item" => $data["request"][$a]["request_item"][$items]["id_request_item"]))->num_rows();

                $data["request"][$a]["request_item"][$items]["jumlahHargaShipping"] = $this->Mdharga_vendor->getListHargaShipping(array("price_request_item.id_request_item" => $data["request"][$a]["request_item"][$items]["id_request_item"]))->num_rows();
                /*sampe sini*/
            }
            
        }
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/vendor-deal/category-header");
        $this->load->view("crm/vendor-deal/category-body",$data);
        $this->load->view("crm/content-close");
        $this->close();
    }
    public function produk($id_submit_request){ //sudah di cek
        /*harusnya ini tampilin dulu semua barangnya apa aja*/
        //$this->session->id_request = $id_request;
        $this->session->link = $id_submit_request;
        $where = array(
            "request_item" => array(
                "id_submit_request" => $id_submit_request,
                "status_request_item" => 0,
            ),
            "supplier" => array(
                "peran_perusahaan" => "PRODUK",
                "status_perusahaan" => 0
            ),
            "shipper" => array(
                "peran_perusahaan" => "SHIPPING",
                "status_perusahaan" => 0
            ),
            "matauang" => array(),
            "detail_request" => array(
                "id_submit_request" => $id_submit_request
            )
        );
        $field = array(
            "request_item" => array(
                "nama_produk","id_request_item","jumlah_produk","notes_produk","file"
            ),
            "mata_uang" => array(
                "mata_uang"
            ),
            "supplier" => array(
                "id_perusahaan","nama_perusahaan"
            ),
            "detail_request" => array(
                "id_perusahaan","franco"
            )
        );
        $print = array(
            "request_item" => array(
                "nama_produk","id_request_item","jumlah","notes","file"
            ),
            "mata_uang" => array(
                "mata_uang"
            ),
            "supplier" => array(
                "id_perusahaan","nama_perusahaan"
            ),
            "detail_request" => array(
                "id_perusahaan","franco"
            )
        );
        $result["request_item"] = selectRow("price_request_item",$where["request_item"]);
        $data["request_item"] = foreachMultipleResult($result["request_item"],$field["request_item"],$print["request_item"]);

        $result["mata_uang"] = selectRow("mata_uang",$where["matauang"]);
        $data["mata_uang"] = foreachMultipleResult($result["mata_uang"],$field["mata_uang"],$print["mata_uang"]);

        $result["supplier"] = $this->Mdperusahaan->getListPerusahaan($where["supplier"]);
        $data["supplier"] = foreachMultipleResult($result["supplier"],$field["supplier"],$print["supplier"]);
        
        $result["shipper"] = $this->Mdperusahaan->getListPerusahaan($where["shipper"]);
        $data["shipper"] = foreachMultipleResult($result["shipper"],$field["supplier"],$print["supplier"]);

        $result["detail_request"] = selectRow("price_request",$where["detail_request"]);
        $data["detail_request"] = foreachResult($result["detail_request"],$field["detail_request"],$print["detail_request"]);
        $data["detail_request"]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data["detail_request"]["id_perusahaan"]));
        $data["detail_request"]["alamat_pengiriman"] = get1Value("perusahaan","alamat_pengiriman",array("id_perusahaan" => $data["detail_request"]["id_perusahaan"]));
        $this->req();
        $this->load->view("crm/content-open");
        $this->load->view("crm/vendor-deal/category-header");
        $this->load->view("crm/vendor-deal/product-vendor-price",$data);
        $this->load->view("crm/content-close");
        $this->close();
        $this->load->view("crm/vendor-deal/js/request-ajax");
    }
    /*function*/
    public function delete($i){ //sudah di cek
        $where = array(
            "price_request.id_request" => $i
        );
        $data = array(
            "price_request.status_aktif_request" => 1
        );
        $this->Mdprice_request->update($data,$where);
        redirect("crm/vendor");
    }
    public function submit($i){
        $where = array(
            "price_request.id_request" => $i
        );
        $data = array(
            "price_request.status_request" => 3
        );
        $this->Mdprice_request->update($data,$where);
        redirect("crm/vendor");
    }
    public function insertHargaSupplier(){ //sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData["file_name"] = "-";
        }
        $data = array(
            "id_request_item" =>  $this->session->id_request_item,
            "id_perusahaan" =>  $this->input->post("id_perusahaan"),
            "id_cp" =>  $this->input->post("id_cp"),
            "nama_produk_vendor" =>  $this->input->post("nama_produk_vendor"),
            "harga_produk" =>  splitterMoney($this->input->post("price"),","),
            "vendor_price_rate" => splitterMoney($this->input->post("rate"),","),
            "mata_uang" => $this->input->post("currency"),
            "notes" => $this->input->post("notes"),
            "attachment" =>  $fileData["file_name"],
        );
        insertRow("harga_vendor",$data);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function insertHargaCourier(){ //sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData["file_name"] = "-";
        }
        $data = array(
            "id_request_item" =>  $this->session->id_request_item,
            "id_perusahaan" =>  $this->input->post("id_perusahaan"),
            "id_cp" =>  $this->input->post("id_cp"),
            "harga_produk" =>  splitterMoney($this->input->post("price"),","),
            "vendor_price_rate" => splitterMoney($this->input->post("rate"),","),
            "metode_pengiriman" => $this->input->post("metode_pengiriman"),
            "mata_uang" => $this->input->post("currency"),
            "notes" => $this->input->post("notes"),
            "attachment" =>  $fileData["file_name"],
        );
        insertRow("harga_courier",$data);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function insertHargaShipping(){ //sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData["file_name"] = "-";
        }
        $data = array(
            "id_harga_vendor" =>  $this->input->post("id_harga_vendor"),
            "id_perusahaan" =>  $this->input->post("id_perusahaan"),
            "id_cp" =>  $this->input->post("id_cp"),
            "harga_produk" =>  splitterMoney($this->input->post("price"),","),
            "vendor_price_rate" => splitterMoney($this->input->post("rate"),","),
            "metode_pengiriman" => $this->input->post("metode_pengiriman"),
            "mata_uang" => $this->input->post("currency"),
            "notes" => $this->input->post("notes"),
            "attachment" =>  $fileData["file_name"],
        );
        insertRow("harga_shipping",$data);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function editHargaSupplier(){//sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "nama_produk_vendor" => $this->input->post("nama_produk_vendor"),
                "notes" => $this->input->post("notes"),
                "attachment" => $fileData["file_name"]
            );
            $where = array(
                "id_harga_vendor" => $this->input->post("id_harga_vendor")
            );
            updateRow("harga_vendor",$data,$where);
        }
        else{
            $fileData["file_name"] = "-";
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "nama_produk_vendor" => $this->input->post("nama_produk_vendor"),
                "notes" => $this->input->post("notes"),
            );
            $where = array(
                "id_harga_vendor" => $this->input->post("id_harga_vendor")
            );
            updateRow("harga_vendor",$data,$where);
        }
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function editHargaCourier(){//sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "metode_pengiriman" => $this->input->post("metode_pengiriman"),
                "notes" => $this->input->post("notes"),
                "attachment" => $fileData["file_name"]
            );
            $where = array(
                "id_harga_courier" => $this->input->post("id_harga_courier")
            );
            updateRow("harga_courier",$data,$where);
        }
        else{
            $fileData["file_name"] = "-";
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "metode_pengiriman" => $this->input->post("metode_pengiriman"),
                "notes" => $this->input->post("notes"),
            );
            $where = array(
                "id_harga_courier" => $this->input->post("id_harga_courier")
            );
            updateRow("harga_courier",$data,$where);
        }
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function editHargaShipper(){ //sudah di cek
        $config = array(
            "upload_path" => "./assets/dokumen/hargasupplier/",
            "allowed_types" => "xls|xlsx|doc|docx|pdf|zip|jpg|jpeg|png|gif"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "metode_pengiriman" => $this->input->post("metode_pengiriman"),
                "notes" => $this->input->post("notes"),
                "attachment" => $fileData["file_name"]
            );
            $where = array(
                "id_harga_shipping" => $this->input->post("id_harga_shipping")
            );
            updateRow("harga_shipping",$data,$where);
        }
        else{
            $fileData["file_name"] = "-";
            $data = array(
                "harga_produk" => splitterMoney($this->input->post("harga_produk"),","),
                "vendor_price_rate" => splitterMoney($this->input->post("vendor_price_rate"),","),
                "mata_uang" => $this->input->post("mata_uang"),
                "metode_pengiriman" => $this->input->post("metode_pengiriman"),
                "notes" => $this->input->post("notes"),
            );
            $where = array(
                "id_harga_shipping" => $this->input->post("id_harga_shipping")
            );
            updateRow("harga_shipping",$data,$where);
        }
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function deleteHargaVendor($id_harga_vendor){ //sudah di cek 

        $where = array(
            "id_harga_vendor" => $id_harga_vendor
        );
        deleteRow("harga_vendor",$where);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function deleteHargaCourier($id_harga_courier){ //sudah di cek
        $where = array(
            "id_harga_courier" => $id_harga_courier
        );
        deleteRow("harga_courier",$where);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function deleteHargaShipping($id_harga_shipping){ //sudah di cek
        $where = array(
            "id_harga_shipping" => $id_harga_shipping
        );
        deleteRow("harga_shipping",$where);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function insertNewSupplier(){ //sudah di cek
        $data = array(
            "nama_perusahaan" => $this->input->post("add_nama_supplier"),
            "alamat_perusahaan" => $this->input->post("add_address_pic"),
            "permanent" => 1,
            "peran_perusahaan" => "PRODUK",
        );
        $id_perusahaan = insertRow("perusahaan",$data);
        $data = array(
            "nama_cp" => $this->input->post("add_pic"),
            "jk_cp" => $this->input->post("add_jk_pic"),
            "email_cp" => $this->input->post("add_email_pic"),
            "nohp_cp" => $this->input->post("add_phone_pic"),
            "id_perusahaan" => $id_perusahaan
        );
        insertRow("contact_person",$data);
        redirect("crm/vendor/produk/".$this->session->link);
    }
    public function insertNewShipper(){ //sudah di cek
        $data = array(
            "nama_perusahaan" => $this->input->post("add_nama_supplier"),
            "permanent" => 1,
            "peran_perusahaan" => "SHIPPING",
        );
        $id_perusahaan = insertRow("perusahaan",$data);
        $data = array(
            "nama_cp" => $this->input->post("add_pic"),
            "jk_cp" => $this->input->post("add_jk_pic"),
            "email_cp" => $this->input->post("add_email_pic"),
            "nohp_cp" => $this->input->post("add_phone_pic"),
            "id_perusahaan" => $id_perusahaan
        );
        insertRow("contact_person",$data);
        redirect("crm/vendor/produk/".$this->session->link);
    }
}
?>