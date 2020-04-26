<?php
class Quotation extends CI_Controller{
    public function addItemToQuotation(){
        $satuan = $this->input->post("satuan_produk");
        $split = explode(",",$satuan);
        $data = array(
            "id_submit_quotation" => $this->input->post("id_submit_quotation"),
            "id_request_item" => $this->input->post("id_request_item"),
            "nama_produk_leiter" => $this->input->post("nama_produk_leiter"),
            "gambar_item" => $this->input->post("gambar_item"),
            "id_harga_shipping" => $this->input->post("id_harga_shipping"),
            "id_harga_vendor" => $this->input->post("id_harga_vendor"),
            "id_harga_courier" => $this->input->post("id_harga_courier"),
            "item_amount" => $split[0], /*nanti ini hasil split*/
            "satuan_produk" => $split[1], /*nanti ini hasil split*/
            "selling_price" => $this->input->post("selling_price"),
            "margin_price" => $this->input->post("margin_price"),
        );
        insertRow("quotation_item",$data);
    }
    public function getQuotationItem(){
        $where = array(
            "no_quotation" => $this->input->post("no_quotation"),
            "versi_quotation" => $this->input->post("quo_version"),
        );  
        $field = array(
            "id_quotation_item","id_request_item","item_amount","selling_price","margin_price"
        );
        $print = array(
            "id_quotation_item","id_request_item","item_amount","selling_price","margin_price"
        );
        $result = selectRow("quotation_item",$where);
        $data = foreachMultipleResult($result,$field,$print);
        for($a = 0; $a<count($data);$a++){
            $data[$a]["nama_produk"] = get1Value("price_request_item","nama_produk",array("id_request_item" => $data[$a]["id_request_item"]));
            $data[$a]["selling_price"] = number_format($data[$a]["selling_price"]);
            $data[$a]["margin_price"] = number_format($data[$a]["margin_price"],2);
        }
        echo json_encode($data);
    }
    public function countTotalQuotationPrice(){
        $where = array(
            "no_quotation" => $this->input->post("no_quotation"),
            "versi_quotation" => $this->input->post("versi_quotation"),
        );
        //print_r($where);
        echo json_encode(getTotal("quotation_item","selling_price",$where));
    }
    /* di pake di OC*/
    public function getQuotationDetail(){ 
        $where = array(
            "id_submit_quotation" => $this->input->post("id_submit_quotation")
        );
        $result = selectRow("quotation",$where);
        $field = array(
            "id_submit_quotation","id_request","up_cp","durasi_pengiriman","durasi_pembayaran","franco","total_quotation_price"
        );
        $data = foreachResult($result,$field,$field);
        $data["id_submit_request"] = get1Value("quotation","id_request", array("id_submit_quotation" => $data["id_submit_quotation"]));
        $data["id_perusahaan"] = get1Value("price_request","id_perusahaan",array("id_submit_request" => $data["id_submit_request"]));
        $data["id_cp"] = get1Value("price_request","id_cp",array("id_submit_request" => $data["id_submit_request"]));

        $data["nama_perusahaan"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $data["id_perusahaan"]));
        $data["alamat_perusahaan"] = get1Value("perusahaan","alamat_perusahaan",array("id_perusahaan" => $data["id_perusahaan"]));
        $data["nama_cp"] = get1Value("contact_person","nama_cp",array("id_cp" => $data["id_cp"]));
        echo json_encode($data);
    }
    public function getOrderedItem(){
        $where = array(
            "id_submit_quotation" => $this->input->post("id_submit_quotation")
        );
        $result = selectRow("quotation_item",$where);
        $field = array(
            "id_quotation_item","id_request_item","item_amount","satuan_produk","selling_price","nama_produk_leiter"
        );
        $data = foreachMultipleResult($result,$field,$field);
        for($a = 0; $a<count($data);$a++){
            $data[$a]["selling_price"] = number_format($data[$a]["selling_price"]);
        }
        echo json_encode($data);
    }
    public function getMetodePembayaran(){
        $where = array(
            "id_submit_quotation" => $this->input->post("id_submit_quotation")
        );
        $result = selectRow("quotation_metode_pembayaran",$where);
        $field = array(
            "persentase_pembayaran","nominal_pembayaran","trigger_pembayaran","is_ada_transaksi","persentase_pembayaran2","nominal_pembayaran2","trigger_pembayaran2","is_ada_transaksi2","kurs"
        );
        $data = foreachResult($result,$field,$field);
        if($data["trigger_pembayaran"] == 1 ){
            $data["trigger_pembayaran"] = "BEFORE DELIVERY";
        }
        else{
            $data["trigger_pembayaran"] = "AFTER DELIVERY";
        }
        if($data["trigger_pembayaran2"] == 1 ){

            $data["trigger_pembayaran2"] = "BEFORE DELIVERY";
        }
        else{
            $data["trigger_pembayaran2"] = "AFTER DELIVERY";
        }
        echo json_encode($data);

    }
    /* di pake di OC*/
}
?>