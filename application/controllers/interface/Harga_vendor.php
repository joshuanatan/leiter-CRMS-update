<?php
class Harga_vendor extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    /* 
    method ini akan digunakan untuk mendapatkan harga supplier
    parameter: 
    -id_request_item (ini dikarenakan, harga supplier sangat terikat pada item dalam 1 RFQ)
    -id_supplier

    return value: harga_vendor
    */
    public function getSupplierPrice($id_request_item,$id_supplier){
        $where = array(
            "id_request_item" => $id_request_item,
            "id_perusahaan" => $id_supplier
        );
        $field = array(
            "harga_produk","vendor_price_rate"
        );
        $print = array(
            "harga_produk","vendor_price_rate"
        );
        $result = selectRow("harga_vendor",$where);
        $data = foreachResult($result,$field,$print);
        $harga_vendor = $data["harga_vendor"]*$data["vendor_price_rate"];
        echo json_encode($harga_vendor);
    }
    /*
    method ini ditujukan untuk mendapatkan harga dari setiap supplier dari 1 request item
    parameter: id_request_item
    return value: 
    -id_harga_vendor,
    -id_perusahaan,
    -id_cp,
    -harga_produk,
    -vendor_price_
    -rate,
    -mata_uang,
    -notes
    -harga_vendor = harga x kurs
    -nama_vendor
    -nama_cp
    -email_cp
    -nohp_cp
    */
    public function getEachSupplierPrice($id_request_item){
        $where = array(
            "id_request_item" => $id_request_item
        );
        $field = array(
            "id_harga_vendor","id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","nama_produk_vendor"
        );
        $print = array(
            "id_harga_vendor","id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","nama_produk_vendor"
        );
        $result = selectRow("harga_vendor",$where);
        $data = foreachMultipleResult($result,$field,$print);
        for($a = 0; $a<count($data);$a++){
            $data[$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data[$a]["id_perusahaan"]));
            $data[$a]["nama_cp"] = get1Value("contact_person","nama_cp",array("id_cp" => $data[$a]["id_cp"]));
        }
        echo json_encode($data);
    }
    public function getEachCourierPrice($id_request_item){
        $where = array(
            "id_request_item" => $id_request_item
        );
        $field = array(
            "id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","metode_pengiriman","id_harga_courier"
        );
        $print = array(
            "id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","metode_pengiriman","id_harga_courier"
        );
        $result = selectRow("harga_courier",$where);
        $data = foreachMultipleResult($result,$field,$print);
        for($a = 0; $a<count($data);$a++){
            $data[$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data[$a]["id_perusahaan"]));
            $data[$a]["nama_cp"] = get1Value("contact_person","nama_cp",array("id_cp" => $data[$a]["id_cp"]));
        }
        echo json_encode($data);
    }
    public function getEachShippingPrice($id_harga_vendor){
        $where = array(
            "id_harga_vendor" => $id_harga_vendor
        );
        $field = array(
            "id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","metode_pengiriman",
            "id_harga_shipping"
        );
        $print = array(
            "id_perusahaan","id_cp","harga_produk", "vendor_price_rate","mata_uang","notes","attachment","metode_pengiriman",
            "id_harga_shipping"
        );
        $result = selectRow("harga_shipping",$where);
        $data = foreachMultipleResult($result,$field,$print);
        for($a = 0; $a<count($data);$a++){
            $data[$a]["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data[$a]["id_perusahaan"]));
            $data[$a]["nama_cp"] = get1Value("contact_person","nama_cp",array("id_cp" => $data[$a]["id_cp"]));
        }
        echo json_encode($data);
    }
    /*method ini digunakan untuk menginsert harga vendor*/
    public function insertVendorPrice(){
        $data = $this->input->post("harga_vendor_data");
        insertRow("harga_vendor",$data);
    }
    public function getVendorPriceForPo(){
        $id_oc_item = $this->input->post("id_oc_item");
        $id_perusahaan = $this->input->post("id_supplier");
        $id_quotation_item = get1value("order_confirmation_item","id_quotation_item",array("id_oc_item" => $id_oc_item));
        $id_request_item = get1value("quotation_item","id_request_item",array("id_quotation_item" => $id_quotation_item));
        $detail_harga_vendor = selectRow("harga_vendor",array("id_perusahaan" => $id_perusahaan,"id_request_item"=>$id_request_item));
        $field = array(
            "harga_produk","nama_produk_vendor","mata_uang"
        );
        $data = array();
        if($detail_harga_vendor->num_rows() > 0){
            $final_detail = foreachResult($detail_harga_vendor,$field,$field);
            $data = array(
                "harga_produk" => $final_detail["harga_produk"],
                "nama_produk_vendor" => $final_detail["nama_produk_vendor"],
                "mata_uang" => $final_detail["mata_uang"]
            );
        }
        else{
            $data = array(
                "harga_produk" => "NO DATA, PLEASE UNCHECK IF NOT ORDERING",
                "nama_produk_vendor" => "NO DATA, PLEASE UNCHECK IF NOT ORDERING",
                "mata_uang" => "NO DATA, PLEASE UNCHECK IF NOT ORDERING"
            ); 
        }
        echo json_encode($data);
    }
}