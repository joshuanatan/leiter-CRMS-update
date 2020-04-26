<?php
class Welcome extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mduser");
    }
    public function index(){
        $this->session->sess_destroy();
        $this->load->view("req/head");
        $this->load->view("login/css/page-css");
        $this->load->view("req/head-close");
        $this->load->view("login/login-open");
        $this->load->view("login/main-logo");
        $this->load->view("login/main-form");
        //$this->load->view("req/footer");
        $this->load->view("login/login-close");
        $this->load->view("req/script");
        $this->load->view("login/js/page-js");
        $this->load->view("req/html-close");
        
    }
    public function auth(){
        $where = array(
            "email_user" => $this->input->post("email"),
            "password" => md5($this->input->post("password")),
            "status_user" => 0
        );
        $result = $this->Mduser->select($where);
        foreach($result->result() as $a){
            $this->session->nama_user = $a->nama_user;
            $this->session->email_user = $a->email_user;
            $this->session->id_user = $a->id_user;
            redirect("welcome");
        }
        redirect("login/welcome/");
    }
    public function logout(){
        redirect("login/welcome/index");
    }
    public function changePassword(){
        $data = array(
            "password" => md5($this->input->post("password"))
        );
        $where = array(
            "id_user" => $this->session->id_user
        );
        updateRow("user",$data,$where);
        redirect("login/welcome");
    }
}

?>