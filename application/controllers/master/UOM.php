<?php
class UOM extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdsatuan");

    }
    private function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome");
        $where = array(
            "uom" => array(
                "status_satuan" => 0
            )
        );
        $result["uom"] = $this->Mdsatuan->select($where["uom"]);
        $counter = 0;
        $data = array(
            "uom" => array()
        );
        foreach($result["uom"]->result() as $a){
            $data["uom"][$counter] = array(
                "id_satuan" => $a->id_satuan,
                "nama_satuan" => $a->nama_satuan
            );
            $counter++;
        }
        $this->req();
        $this->load->view("master/content-open");
        $this->load->view("master/uom/category-header");
        $this->load->view("master/uom/category-body",$data);
        $this->load->view("master/content-close");
        $this->close();
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("master/master-close");
        $this->load->view("req/html-close");
    }
    public function edit($id_satuan){
        $where = array(
            "id_satuan" => $id_satuan
        );
        $data = array(
            "nama_satuan" => strtoupper($this->input->post("nama_satuan"))
        );
        $this->Mdsatuan->update($data,$where);
        redirect("master/uom");
    }
    public function insert(){
        $data = array(
            "nama_satuan" => strtoupper($this->input->post("nama_satuan"))
        );
        $this->Mdsatuan->insert($data);
        redirect("master/uom");
    }
    public function delete($id_satuan){
        $where = array(
            "id_satuan" => $id_satuan
        );
        $data = array(
            "status_satuan" => 1
        );
        $this->Mdsatuan->update($data,$where);
        redirect("master/uom");
    }
}
?>