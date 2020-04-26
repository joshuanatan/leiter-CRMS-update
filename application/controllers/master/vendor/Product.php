<?php
class Product extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdperusahaan");
        $this->load->model("Mdsatuan");
        $this->load->model("Mdcontact_person");
        $this->load->model("Mdproduk_vendor");
        $this->load->model("Mdproduk");

    }
    /*page*/
    public function index(){ //sudah di cek
        if($this->session->id_user == "") redirect("login/welcome");
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /* ------------------------------------------------ */
        $where = array(
            "perusahaan.id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_supplier")) == 0){
            $where = array(
                "peran_perusahaan" => "PRODUK",
                "perusahaan.status_perusahaan" => 0,
                "contact_person.status_cp" => 0,
                "perusahaan.id_user_add" => $this->session->id_user
            );
        }         
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_supplier")) == 0){
            $where = array(
                "peran_perusahaan" => "PRODUK",
                "perusahaan.status_perusahaan" => 0,
                "contact_person.status_cp" => 0
            );
        }
        $field = array(
            "perusahaan.id_perusahaan","nama_perusahaan","alamat_perusahaan","notelp_perusahaan","nama_cp","email_cp","nohp_cp","no_urut"
        );
        $result = $this->Mdperusahaan->select($where,$field);
        $data["perusahaan"] = $result->result_array();

        $where = array(
            "peran_perusahaan" => "PRODUK",
            "status_perusahaan" => 0
        );
        $data["maxId"] = getMaxId("perusahaan","no_urut",$where);
        
        $this->load->view("master/content-open");
        $this->load->view("master/vendor-product/category-header");
        $this->load->view("master/vendor-product/category-body",$data);
        $this->load->view("master/content-close");
        /* ------------------------------------------------ */
        $this->load->view("req/script");
        $this->load->view("plugin/jqtabledit/jqtabledit-js");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("master/master-close");
        $this->load->view("req/html-close");
    }
    public function edit($i){ //sudah di cek
        
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $where = array(
            "perusahaan.id_perusahaan" => $i
        );
        $data = array(
            "perusahaan" => $this->Mdperusahaan->select($where)
        );  
        $this->load->view("master/content-open");
        $this->load->view("master/vendor-product/category-header");
        $this->load->view("master/vendor-product/edit-vendor-product",$data);
        $this->load->view("master/content-close");
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("plugin/jqtabledit/jqtabledit-js");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("master/master-close");
        $this->load->view("req/html-close");
    }

    public function contact($i){ //sudah di cek
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /* ------------------------------------------------ */
        $where = array(
            "contact_person.id_perusahaan" => $i,
            "contact_person.status_cp" => 0,
            
        );
        $data = array(
            "cp" => $this->Mdcontact_person->select($where),
            "id_perusahaan" => $i,
        );
        if($data["cp"]->num_rows() == 1){
            $data["is_last"] = 0;
        }
        else{
            $data["is_last"] = 1;
        }
        
        $this->load->view("master/content-open");
        $this->load->view("master/vendor-product/category-header",$data);
        $this->load->view("master/vendor-product/contact-vendor-product",$data);
        $this->load->view("master/content-close");
        /* ------------------------------------------------ */
        $this->load->view("req/script");
        $this->load->view("plugin/jqtabledit/jqtabledit-js");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        //$this->load->view("master/vendor-product-item/js/ajax-request");
        $this->load->view("master/master-close");
        $this->load->view("req/html-close");
    }
    /*functions*/
    
    public function register(){ //sudah di cek
        $data = array(
            "nama_perusahaan" => $this->input->post("nama_perusahaan"),
            "no_urut" => $this->input->post("no_urut"),
            "nofax_perusahaan" => $this->input->post("nofax_perusahaan"),
            "alamat_perusahaan" => $this->input->post("alamat_perusahaan"),
            "notelp_perusahaan" =>$this->input->post("notelp_perusahaan"),
            "peran_perusahaan" => "PRODUK",
            "id_user_add" => $this->session->id_user
        );
        $id_perusahaan = insertRow("perusahaan",$data);
        $data = array(
            "nama_cp" => $this->input->post("nama_cp"),
            "jk_cp" => $this->input->post("jk_cp"),
            "email_cp" => $this->input->post("email_cp"),
            "nohp_cp" => $this->input->post("nohp_cp"),
            "jabatan_cp" => $this->input->post("jabatan_cp"),
            "id_perusahaan" => $id_perusahaan,
            "id_user_add" => $this->session->id_user
        );
        insertRow("contact_person",$data);
        redirect("master/vendor/product");
    }
    public function delete($i){ //sudah di cek
        
        $where = array(
            "perusahaan.id_perusahaan" => $i
        );
        $data = array(
            "status_perusahaan" => 1,
            "id_user_delete" => $this->session->id_user
        );
        $this->Mdperusahaan->update($data,$where);
        redirect("master/vendor/product");
    }
    public function editvendor(){ //sudah di cek
        $where = array(
            "perusahaan.id_perusahaan" => $this->input->post("id_perusahaan")
        );
        $data = array(
            "nama_perusahaan" => $this->input->post("nama_perusahaan"),
            "nofax_perusahaan" => $this->input->post("nofax_perusahaan"),
            "alamat_perusahaan" => $this->input->post("alamat_perusahaan"),
            "notelp_perusahaan" => $this->input->post("notelp_perusahaan"),
        );
        updateRow("perusahaan",$data,$where);
        redirect("master/vendor/product/edit/".$this->input->post("id_perusahaan"));
    }
    public function removecp($i,$page){ //sudah di cek
        
        $data = array(
            "status_cp" => 1,
            "id_user_delete" => $this->session->id_user
        );
        $where = array(
            "id_cp" => $i
        );  
        $this->Mdcontact_person->update($data,$where);
        redirect("master/vendor/product/contact/".$page);
    }
    public function editcp(){ //sudah dicek
        $nameCp = array("nama_cp","jk_cp","email_cp","nohp_cp","jabatan_cp","id_perusahaan","id_cp");
        $where = array(
            "id_cp" => $this->input->post($nameCp[6])
        );
        $data = array(
            $nameCp[0] => $this->input->post($nameCp[0]),
            $nameCp[1] => $this->input->post($nameCp[1]),
            $nameCp[2] => $this->input->post($nameCp[2]),
            $nameCp[3] => $this->input->post($nameCp[3]),
            $nameCp[4] => $this->input->post($nameCp[4]),
            $nameCp[5] => $this->input->post($nameCp[5]),
            "id_user_edit" => $this->session->id_user
        );
        $this->Mdcontact_person->update($data,$where);
        redirect("master/vendor/product/contact/".$this->input->post($nameCp[5]));
    }
    public function registercp(){ //sudah dicek
        $nameCp = array("nama_cp","jk_cp","email_cp","nohp_cp","jabatan_cp","id_perusahaan");
        $data = array(
            $nameCp[0] => $this->input->post($nameCp[0]),
            $nameCp[1] => $this->input->post($nameCp[1]),
            $nameCp[2] => $this->input->post($nameCp[2]),
            $nameCp[3] => $this->input->post($nameCp[3]),
            $nameCp[4] => $this->input->post($nameCp[4]),
            $nameCp[5] => $this->input->post($nameCp[5]),
            "id_user_add" => $this->session->id_user
        );
        $this->Mdcontact_person->insert($data);
        redirect("master/vendor/product/contact/".$this->input->post($nameCp[5]));
    }
}
?>