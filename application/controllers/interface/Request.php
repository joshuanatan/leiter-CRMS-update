<?php
class Request extends CI_Controller{
    public function getRequestDetail(){
        /*ngambil detail request berdasarkan id_submit_request*/
        $where = array(
            "price_request.id_submit_request" => $this->input->post("id_submit_request")
        );
        $field["price_request"] = array(
            "id_perusahaan","id_cp","franco",
        );
        $result = selectRow("price_request",$where);
        $data["price_request"] = foreachResult($result,$field["price_request"],$field["price_request"]);

        $data["price_request"]["nama_perusahaan"] = strtoupper(get1Value("perusahaan","nama_perusahaan", array("id_perusahaan" => $data["price_request"]["id_perusahaan"])));

        $data["price_request"]["nama_cp"] = strtoupper(get1Value("contact_person","nama_cp", array("id_perusahaan" => $data["price_request"]["id_perusahaan"])));

        $data["price_request"]["alamat_perusahaan"] = get1Value("perusahaan","alamat_perusahaan", array("id_perusahaan" => $data["price_request"]["id_perusahaan"]));

        if($data["price_request"]["alamat_perusahaan"] == "") {
            $data["price_request"]["alamat_perusahaan"] = "NO ADDRESS, NEW CUSTOMER";
        }

        /*ngambil item2 dalam request menggunakan id_submit_request*/
        $where = array(
            "price_request_item.id_submit_request" => $this->input->post("id_submit_request"),
            "price_request_item.status_request_item" => 0
        );
        $field["price_request_item"] = array(
            "id_request_item","nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
        );
        $result = selectRow("price_request_item",$where); /*ambil semua data price request item*/
        $data["price_request_item"] = foreachMultipleResult($result,$field["price_request_item"],$field["price_request_item"]);
        
        /* -------------------------------------------------------------------------------- */
        echo json_encode($data);
    }
    public function getAmountOrders(){
        /*setiap item keganti, akan kena method ini untuk mendapatkan jumlah pesanan, oleh karenanya session id_request_item dapat dipasang disini karena setiap pergantian item akan ternotice oleh sessionnya dan bisa jadi refrensi untuk penggunaan berikutnya*/
        $this->session->id_request_item = $this->input->post("id_request_item");
        $where = array(
            "id_request_item" => $this->input->post("id_request_item")
        );
        $jumlah = get1Value("price_request_item","jumlah_produk",$where);
        $satuan = get1Value("price_request_item","satuan_produk",$where);
        echo json_encode($jumlah." ".$satuan);
    }
    public function getNamaProduk(){
        /*setiap item keganti, akan kena method ini untuk mendapatkan jumlah pesanan, oleh karenanya session id_request_item dapat dipasang disini karena setiap pergantian item akan ternotice oleh sessionnya dan bisa jadi refrensi untuk penggunaan berikutnya*/
        $this->session->id_request_item = $this->input->post("id_request_item");
        $where = array(
            "id_request_item" => $this->input->post("id_request_item")
        );
        $nama_produk = get1Value("price_request_item","nama_produk",$where);
        echo json_encode($nama_produk);
    }
    
}
?>