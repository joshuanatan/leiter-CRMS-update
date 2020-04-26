<?php
class Customer extends CI_Controller{
    public function __construct(){
        parent::__construct();  
        $this->load->model("Mdperusahaan");
        $this->load->model("Mdcontact_person");

    }
    /*page*/
    public function index(){ //sudah di cek
        if($this->session->id_user == "") redirect("login/welcome");
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/contact/contact-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("master/content-open");
        $this->load->view("master/customer/category-header");


        $where = array(
            "perusahaan.id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_customer")) == 0){
            $where = array(
                "peran_perusahaan" => "CUSTOMER",
                "perusahaan.status_perusahaan" => 0,
                "contact_person.status_cp" => 0,
                "perusahaan.id_user_add" => $this->session->id_user
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_customer")) == 0){
            $where = array(
                "peran_perusahaan" => "CUSTOMER",
                "perusahaan.status_perusahaan" => 0,
                "contact_person.status_cp" => 0
            );
        }
        $field = array(
            "perusahaan.id_perusahaan","no_urut","nama_perusahaan","jenis_perusahaan","alamat_perusahaan","alamat_pengiriman","notelp_perusahaan","nofax_perusahaan"
        );
        $result = $this->Mdperusahaan->select($where,$field);
        $data["perusahaan"] = $result->result_array();

        for($a = 0; $a<count($data["perusahaan"]); $a++){
            
            $where = array(
                "id_perusahaan" => $data["perusahaan"][$a]["id_perusahaan"],
                "status_cp" => 0
            );
            $field = array(
                "nama_cp","email_cp","nohp_cp"
            );
            $result = selectRow("contact_person",$where,$field);
            $data["perusahaan"][$a]["cp"] = $result->result_array();
        }
        $data["maxId"] = getMaxId("perusahaan","no_urut",array("peran_perusahaan" => "customer","status_perusahaan" => 0));
        $this->load->view("master/customer/category-body",$data);
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
    public function edit($id_perusahaan){ //sudah di cek
        
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/contact/contact-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $where = array(
            "perusahaan.id_perusahaan" => $id_perusahaan
        );
        $data["perusahaan"] = selectRow("perusahaan",$where);  
        $this->load->view("master/content-open");
        $this->load->view("master/customer/category-header");
        $this->load->view("master/customer/edit-customer",$data);
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
    public function register(){ //sudah di cek
        $data = array(
            "no_urut" => $this->input->post("no_urut"),
            "nama_perusahaan" => $this->input->post("nama_perusahaan"),
            "nofax_perusahaan" => $this->input->post("nofax_perusahaan"),
            "alamat_perusahaan" => $this->input->post("alamat_perusahaan"),
            "alamat_pengiriman" => $this->input->post("alamat_pengiriman"),
            "notelp_perusahaan" => $this->input->post("notelp_perusahaan"),
            "peran_perusahaan" => "CUSTOMER",
            "jenis_perusahaan" => $this->input->post("jenis_perusahaan"),
            "permanent" => 0,
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
        redirect("master/customer");
    }
    public function editcustomer(){ //sudah di cek
        $where = array(
            "perusahaan.id_perusahaan" => $this->input->post("id_perusahaan")
        );
        $data = array(
            "nama_perusahaan" => $this->input->post("nama_perusahaan"),
            "nofax_perusahaan" => $this->input->post("nofax_perusahaan"),
            "jenis_perusahaan" => $this->input->post("jenis_perusahaan"),
            "alamat_perusahaan" => $this->input->post("alamat_perusahaan"),
            "alamat_pengiriman" => $this->input->post("alamat_pengiriman"),
            "notelp_perusahaan" => $this->input->post("notelp_perusahaan"),
            "id_user_edit" => $this->session->id_user
        );
        updateRow("perusahaan",$data,$where);
        redirect("master/customer/edit/".$this->input->post("id_perusahaan"));
    }
    public function contact($id_perusahaan){ //sudah di cek
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/contact/contact-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("master/content-open");
        $this->load->view("master/customer/category-header");
        $where = array(
            "contact_person.id_perusahaan" => $id_perusahaan,
            "contact_person.status_cp" => 0
        );
        $data = array(
            "cp" => $this->Mdcontact_person->select($where),
            "id_perusahaan" => $id_perusahaan
        );
        if($data["cp"]->num_rows() == 1){
            $data["is_last"] = 0;
        }
        else{
            $data["is_last"] = 1;
        }
        $this->load->view("master/customer/contact-customer",$data);
        $this->load->view("master/content-close");
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("master/master-close");
        $this->load->view("req/html-close");
    }
    public function removecp($id_cp,$page){ //sudah di cek
        $data = array(
            "status_cp" => 1,
            "id_user_delete" => $this->session->id_user
        );
        $where = array(
            "id_cp" => $id_cp
        );  
        $this->Mdcontact_person->update($data,$where);
        redirect("master/customer/contact/".$page);
    }
    public function registercp(){ //sudah di cek
        $data = array(
            "nama_cp" => $this->input->post("nama_cp"),
            "jk_cp" => $this->input->post("jk_cp"),
            "email_cp" => $this->input->post("email_cp"),
            "nohp_cp" => $this->input->post("nohp_cp"),
            "jabatan_cp" => $this->input->post("jabatan_cp"),
            "id_perusahaan" => $this->input->post("id_perusahaan"),
            "id_user_add" => $this->session->id_user
        );
        insertRow("contact_person",$data);
        redirect("master/customer/contact/".$this->input->post("id_perusahaan"));
    }
    public function editcp(){ //sudah di cek
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
        redirect("master/customer/contact/".$this->input->post($nameCp[5]));
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
        redirect("master/customer/");
    }
    public function showTransaction($id_perusahaan){
        $where = array(
            "status_aktif_oc" => 0,
            "id_perusahaan" => $id_perusahaan
        );
        $field = array(
            "id_submit_quotation","no_po_customer","no_oc","id_oc","bulan_oc","tahun_oc","id_submit_oc","tgl_po_customer","total_oc_price","nama_perusahaan","nama_cp","no_quotation"
        );
        $result = selectRow("order_detail",$where,$field);

        $data["oc"]= $result->result_array();

        for($a = 0; $a<count($data["oc"]);$a++){
            
            $where = array(
                "id_submit_oc" => $data["oc"][$a]["id_submit_oc"]
            );
            $field = array(
                "id_oc_item","nama_oc_item","final_amount_oc","satuan_produk_oc","final_selling_price_oc","status_oc_item"
            );
            $result = selectRow("order_item_detail",$where,$field);
            $data["oc"][$a]["oc_item"] = $result->result_array();

            $where = array(
                "id_submit_oc" => $data["oc"][$a]["id_submit_oc"]
            );
            $field = array(
                "persentase_pembayaran","nominal_pembayaran","trigger_pembayaran","status_bayar","is_ada_transaksi","persentase_pembayaran2","nominal_pembayaran2","trigger_pembayaran2","status_bayar2","is_ada_transaksi2","kurs"
            );
            $result = selectRow("order_confirmation_metode_pembayaran",$where,$field);
            $data["oc"][$a]["metode_pembayaran"] = $result->result_array();

            if($data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] == 1){
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] = "BEFORE ORDER DELIVERY";
            }
            else{
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran"] = "AFTER ORDER DELIVERY";
            }
            if($data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] == 1){
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] = "BEFORE ORDER DELIVERY";
            }
            else{
                $data["oc"][$a]["metode_pembayaran"][0]["trigger_pembayaran2"] = "AFTER ORDER DELIVERY";
            }

        }
        $where = array(
            "status_aktif_oc" => 0,
            "id_perusahaan" => $id_perusahaan
        );
        $field = array(
            "count(id_submit_oc) as jumlah_transaksi"
        );
        $result = selectRow("order_detail",$where,$field);
        $result_array = $result->result_array();
        $data["jumlah_transaksi"] = $result_array[0]["jumlah_transaksi"];
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/contact/contact-css");
        $this->load->view("req/head-close");
        $this->load->view("master/master-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("master/content-open");
        $this->load->view("master/customer/category-header");
        $this->load->view("master/customer/transaction",$data);
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
}
?>