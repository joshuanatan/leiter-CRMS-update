<?php
class Od extends CI_Controller{
    public function isExists(){
        $where = array(
            "no_od" => $this->input->post("no_refrence")
        );
        echo json_encode(isExistsInTable("od_core",$where));

    }  
    public function getOd(){
        $where = array(
            "no_oc" => $this->input->post("no_oc")
        );
        $field = array(
            "id_od","no_od"
        );
        $print = array(
            "id_od","no_od"
        );
        $result = selectRow("od_core",$where);
        $data = foreachMultipleResult($result,$field,$print);
        
        echo json_encode($data);
    }
    public function getOdItemPayment(){ //kepake di invoice
        $total = 0;
        $where = array(
            "id_submit_od" => $this->input->post("id_submit_od") /*1 od bisa banyak item*/
        );
        //echo $this->input->post("id_od");
        $field = array(
            "id_od_item","id_submit_od","id_oc_item","item_qty"
        );
        $result = selectRow("od_item",$where);
        $data["items"] = foreachMultipleResult($result,$field,$field); /*1 od bisa banyak item*/

        for($a = 0; $a<count($data["items"]);$a++){ /*puter setiap item*/
            /*ambil harga, item, dan nama produk tiap item*/
            $data["items"][$a]["nama_produk"] = nl2br(get1Value("order_confirmation_item","nama_oc_item",array("id_oc_item" => $data["items"][$a]["id_oc_item"])));
            $data["items"][$a]["final_amount"] = get1Value("order_confirmation_item","final_amount",array("id_oc_item" => $data["items"][$a]["id_oc_item"]));
            $data["items"][$a]["satuan_produk"] = get1Value("order_confirmation_item","satuan_produk",array("id_oc_item" => $data["items"][$a]["id_oc_item"]));
            $data["items"][$a]["final_selling_price"] = get1Value("order_confirmation_item","final_selling_price",array("id_oc_item" => $data["items"][$a]["id_oc_item"])); //ini satuan, hati2
            $data["items"][$a]["final_price"] = $data["items"][$a]["final_selling_price"]*$data["items"][$a]["item_qty"]; //yang dikirim * harga satuan
            $total += $data["items"][$a]["final_price"]; //belom di potong DP
        }
        $id_submit_oc = get1Value("od_core","id_submit_oc",$where);
        $persentase_pembayaran2 = get1Value("order_confirmation_metode_pembayaran","persentase_pembayaran2",array("id_submit_oc" => $id_submit_oc)); //mencari persen sisa
        $data["harga_po"] = $total;
        $total = $total * $persentase_pembayaran2 / 100; //dikali persen sisa

        $data["subtotal"] = $total;
        echo json_encode($data);
    }
    /*************************************************************** */
    public function getSentItemAmount(){
        $where = array(
            "id_oc_item" => $this->input->post("id_oc_item")
        );
        $jumlah_terkirim = 0;
        $jumlah_terkirim = getTotal("od_item","item_qty",$where);
        echo json_encode(array("jumlah_terkirim" => $jumlah_terkirim));
    }
    public function getListOdForPelunasan(){
        $where = array(
            "id_submit_oc" => $this->input->post("id_submit_oc")
        );
        $field = array(
            "no_od","id_submit_od","date_od_add"
        );
        $result = selectRow("od_core",$where);
        $data = foreachMultipleResult($result,$field,$field);
        for($a = 0; $a<count($data);$a++){
            $date = date_create($data[$a]["date_od_add"]);
            $data[$a]["date_od_add"] = date_format($date,"d-m-Y");
        }
        echo json_encode($data);
    }
}
?>