<?php
class Invoice extends CI_Controller{
    public function getDp(){
        $where = array(
            "no_oc" => $this->input->post("no_oc"),
            "status_invoice" => 1,
            "trigger_pembayaran" => 1
        );
        $field = array(
            "nominal_pembayaran","persentase_pembayaran"
        );
        $print = array(
            "nominal_pembayaran","persentase_pembayaran"
        );

        $result = selectRow("metode_pembayaran",$where);
        $data = foreachResult($result,$field,$print);
        $data["persentase"] = $data["persentase_pembayaran"];
        $data["nominal"] = number_format($data["nominal_pembayaran"]);
        $data["total"] = number_format(100*$data["nominal_pembayaran"]/$data["persentase_pembayaran"]);
        $data["clean_nominal"] = $data["nominal_pembayaran"];

        $total = $data["nominal_pembayaran"];
        $this->session->totalinvoice = $total;
        echo json_encode($data);

    }
}
?>