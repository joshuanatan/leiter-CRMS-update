<?php
class expanses extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdfinance_usage_type");
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
            "id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_expanses")) == 0){
            $where = array(
                "status_type" => 0,
                "id_user_add" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_expanses")) == 0){
            $where = array(
                "status_type" => 0,
            );
        }
        $field = array(
            "id_type","is_patent","name_type","kode_type","status_type"
        );
        $result = selectRow("finance_usage_type",$where,$field);
        $data["finance_type"] = $result->result_array();
        
        $this->req();
        $this->load->view("master/content-open");
        $this->load->view("master/expanses/category-header");
        $this->load->view("master/expanses/category-body",$data);
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
    public function insert(){
        $data = array(
            "is_patent" => 1,
            "name_type" => ucwords($this->input->post("name_type")),
            "kode_type" => $this->input->post("kode_type"),
            "status_type" => 0,
            "id_user_add" => $this->session->id_user
        );
        insertRow("finance_usage_type",$data);
        redirect("master/expanses");
    }
    public function delete($id_type){
        $where = array(
            "id_type" => $id_type
        );
        $data = array(
            "status_type" => 1
        );
        $this->Mdfinance_usage_type->update($data,$where);
        redirect("master/expanses");
    }
    public function edit($id_type){
        $where = array(
            "id_type" => $id_type
        );
        $data = array(
            "name_type" => ucwords($this->input->post("name_type")),
            "kode_type" => $this->input->post("kode_type"),
            "id_user_edit" => $this->session->id_user
        );
        $this->Mdfinance_usage_type->update($data,$where);
        redirect("master/expanses");
    }
}
?>