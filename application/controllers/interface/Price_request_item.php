<?php
class Price_request_item extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    /*
    method ini digunakan untuk mendapatkan detail dari item yang direquest dari RFQ
    parameter: id_request_item
    return value : nama_produk, jumlah_produk, notes_produk, file
    */
    public function getDetailRequestItem($id_request_item){
        $this->session->id_request_item = $id_request_item; /*untuk ngeset harga vendor butuh id_request_item*/
        $where = array(
            "id_request_item" => $id_request_item
        );
        $field = array(
            "nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
        );
        $print = array(
            "nama_produk","jumlah_produk","notes_produk","file","satuan_produk"
        );
        $result = selectRow("price_request_item",$where);
        $data = foreachResult($result,$field,$print);
        echo json_encode($data);
    }
    
}