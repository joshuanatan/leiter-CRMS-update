<?php
class Welcome extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mduser");
        $this->load->model("Mdmenu");
        $this->load->model("Mddashboard");
    }
    public function index(){
        if($this->session->id_user == "") redirect("login/welcome");
        $year = date("Y");
        $durasi = 3;

        $field = array(
            "bulan_invoice","tahun_invoice","total"
        );
        $where = array();
        $result = $this->Mddashboard->getSalesMonthly($field,$where,$year,$durasi);
        $data["penghasilan"] = $result->result_array();

        $field = array(
            "count(distinct(no_po_customer)) as total",
            "bulan_oc",
            "tahun_oc"
        );
        $where = array();
        $result = $this->Mddashboard->getJumlahPo($field,$where,$year,$durasi);
        $data["po"] = $result->result_array();

        $result = $this->Mddashboard->getCustomerOrder($year);
        $data["customer_order"] = $result->result_array();
        
        $this->load->view("req/head");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("req/head-close");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("dashboard/main");
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("req/html-close");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("dashboard/js/main-js",$data);
    }
    public function user(){
        if($this->session->id_user == "") redirect("login/welcome");
        $year = date("Y");
        $durasi = 3;
        $last_sunday = tanggalDariHariTerdekat("sunday",date("Y-m-d"));
        $tanggal_senin_mingguan = tambahHariKeTanggal($last_sunday,1,"day");
        $tanggal_hari_ini = date("Y-m-d"); 
        $field = array(
            "id_kpi_user","kpi","target_kpi"
        );  
        $where = array(
            "id_user" => $this->session->id_user,
            "status_aktif_kpi" => 0
        );
        $result = selectRow("kpi_user",$where,$field);
        $data["kpi"] = $result->result_array();
        
        $where = array(
            "id_user_add" => $this->session->id_user
        );
        $constraint = array(
            "awal" => $tanggal_senin_mingguan,
            "akhir" => $tanggal_hari_ini
        );
        $field = array(
            "count(id_report) as jumlah_report","tipe_report"
        );
        $group_by = array(
            "tipe_report"
        );
        $result = selectRowBetweenDates("report","tgl_report",$constraint,$where,$field,$group_by);
        $data["report"] = $result->result_array();

        $where = array(
            "month(tgl_reimburse_add)" => date("m"),
            "year(tgl_reimburse_add)" => date("Y"),
            "id_user_add" => $this->session->id_user,
            "status_paid" => 0
        );
        $field = array(
            "sum(nominal_reimburse) as total_reimburse_terima",
            "count(id_reimburse) as jumlah_reimburse_terima"
        );
        $result = selectRow("reimburse",$where,$field);
        $result_array = $result->result_array();
        $data["total_reimburse_terima"] = $result_array[0]["total_reimburse_terima"];
        $data["jumlah_reimburse_terima"] = $result_array[0]["jumlah_reimburse_terima"];

        $where = array(
            "month(tgl_reimburse_add)" => date("m"),
            "year(tgl_reimburse_add)" => date("Y"),
            "id_user_add" => $this->session->id_user,
            "status_paid" => 1
        );
        $field = array(
            "sum(nominal_reimburse) as total_reimburse_tunggu",
            "count(id_reimburse) as jumlah_reimburse_tunggu",
        );
        $result = selectRow("reimburse",$where,$field);
        $result_array = $result->result_array();
        $data["total_reimburse_tunggu"] = $result_array[0]["total_reimburse_tunggu"];
        $data["jumlah_reimburse_tunggu"] = $result_array[0]["jumlah_reimburse_tunggu"];
        $this->load->view("req/head");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("req/head-close");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("dashboard/user",$data);
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("req/html-close");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("dashboard/js/user-js",$data);
    }
    public function crm(){
        $field = array(
            "id_submit_quotation","no_quotation","total_quotation_price","dateline_quotation","date_quotation_add","waktu_jatuh_tempo","nama_perusahaan","dateline_quotation"
        );
        $where = array(
            "waktu_jatuh_tempo <= " => 5
        );
        $result = selectRow("quotation_jatuh_tempo",$where,$field);
        $data["quotation"] = $result->result_array();

        $field = array(
            "nama_supplier","nama_shipper","no_po","requirement_date","destination","date_po_core_add","waktu_jatuh_tempo","id_submit_po"
        );
        $where = array(
            "waktu_jatuh_tempo <= " => 5,
            "status_aktif_po" => 0
        );
        $result = selectRow("po_jatuh_tempo",$where,$field);
        $data["po"] = $result->result_array();

        $field = array(
            "count(id_submit_request) as jumlah_rfq",
            "bulan_request","tahun_request"
        );
        $where = array(
            "status_aktif_request" => 0,
            "tahun_request" => date("Y")
        );
        $group_by = array(
            "bulan_request"
        );
        $result = selectRow("order_detail",$where,$field,"","","","",$group_by);
        $data["rfq"] = $result->result_array();

        $field = array(
            "count(id_quotation) as quotation_loss", "bulan_quotation","tahun_quotation"
        );
        $where = array(
            "tahun_quotation" => date("Y"),
            "status_quotation" => 1
        );
        $group_by = array(
            "bulan_quotation"
        );
        $result = selectRow("order_detail",$where,$field,"","","","",$group_by);
        $data["loss"] = $result->result_array();

        $field = array(
            "count(id_quotation) as quotation_win", "bulan_quotation","tahun_quotation"
        );
        $where = array(
            "tahun_quotation" => date("Y"),
            "status_quotation" => 0
        );
        $group_by = array(
            "bulan_quotation"
        );
        $result = selectRow("order_detail",$where,$field,"","","","",$group_by);
        $data["win"] = $result->result_array();

        $field = array(
            "count(id_submit_request) as jumlah_request_belom_quotation"
        );
        $where = array(
            "status_buat_quo" => 1,
            "status_aktif_request" => 0
        );
        $result = selectRow("price_request",$where,$field);
        $data["rfq_no_quotation"] = $result->result_array();

        $field = array(
            "count(id_submit_quotation) as jumlah_quotation_followup"
        );
        $where = array(
            "status_quotation" => 0,
            "status_aktif_quotation" => 0
        );
        $result = selectRow("quotation",$where,$field);
        $data["followup_quotation"] = $result->result_array();

        $this->load->view("req/head");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("req/head-close");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("dashboard/crm",$data);
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("req/html-close");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("dashboard/js/crm-js",$data);
        $this->load->view("plugin/datatable/page-datatable-js");
    }
    public function finance(){
        if($this->session->id_user == "") redirect("login/welcome");
        $year = date("Y");
        $field = array(
            "sum(total_pembayaran) as cashflow"
        );
        $where = array(
            "bulan_transaksi" => (int)date("m"),
            "tahun_transaksi" => date("Y")
        );
        $result = selectRow("cashflow_overview",$where,$field);
        $data["cashflow_balance"] = $result->result_array();
        
        $field = array(
            "sum(total_pembayaran) as cashflow"
        );
        $where = array(
            "bulan_transaksi" => (int)date("m"),
            "tahun_transaksi" => date("Y"),
            "total_pembayaran <" => 0
        );
        $result = selectRow("cashflow_overview",$where,$field);
        $data["pengeluaran"] = $result->result_array();
        
        $field = array(
            "sum(total_pembayaran) as cashflow"
        );
        $where = array(
            "bulan_transaksi" => (int)date("m"),
            "tahun_transaksi" => date("Y"),
            "total_pembayaran >" => 0
        );
        $result = selectRow("cashflow_overview",$where,$field);
        $data["pemasukan"] = $result->result_array();
        
        
        $field = array(
            "sum(total_pembayaran) as total_pembayaran"
        );
        $where = array(
            "bulan_transaksi" => (int)date("m"),
            "tahun_transaksi" => date("Y")
        );
        $result = selectRow("margin_overview",$where,$field);
        $selisih = $result->result_array();
        $field = array(
            "sum(total_pembayaran) as total_pembayaran"
        );
        $where = array(
            "bulan_transaksi" => (int)date("m"),
            "tahun_transaksi" => date("Y"),
            "total_pembayaran >" => 0
        );
        $result = selectRow("margin_overview",$where,$field);
        $jual = $result->result_array();
        $data["margin_overview"] = 0;
        if($jual[0]["total_pembayaran"] > 0){
            $data["margin_overview"] = $selisih[0]["total_pembayaran"]/$jual[0]["total_pembayaran"]*100;
        }
        $field = array(
            "sum(total_pembayaran) as total_pembayaran",
            "bulan_transaksi",
            "tahun_transaksi"
        );
        $where = array(
            "tahun_transaksi " => $year,
            "total_pembayaran >" => 0
        );
        $group_by = array(
            "bulan_transaksi"
        );
        $result = selectRow("cashflow_overview",$where,$field,"","","","",$group_by);
        $data["uang_masuk_bulanan"] = $result->result_array();

        $where = array(
            "tahun_transaksi " => $year,
            "total_pembayaran <" => 0
        );
        $group_by = array(
            "bulan_transaksi"
        );
        $result = selectRow("cashflow_overview",$where,$field,"","","","",$group_by);
        $data["uang_keluar_bulanan"] = $result->result_array();
        $field = array(
            "sum(total_pembayaran) as selisih,bulan_transaksi", "tahun_transaksi","bulan_transaksi"
        );
        $where = array(
            "tahun_transaksi >=" => $year-2,
            "total_pembayaran <" => 0  
        );
        $group_by = array(
            "bulan_transaksi","tahun_transaksi"
        );
        $result = selectRow("margin_overview",$where,$field,"","","","",$group_by);
        $data["selisih_untuk_margin"] = $result->result_array();

        $field = array(
            "sum(total_pembayaran) as jual,bulan_transaksi", "tahun_transaksi","bulan_transaksi"
        );
        $where = array(
            "tahun_transaksi >=" => $year-2,
            "total_pembayaran >" => 0  
        );
        $group_by = array(
            "bulan_transaksi","tahun_transaksi"
        );
        $result = selectRow("margin_overview",$where,$field,"","","","",$group_by);
        $data["jual_untuk_margin"] = $result->result_array();

        $field = array(
            "no_invoice","no_po_customer","nominal_pembayaran","tipe_pembayaran","tgl_invoice_add","sisa_waktu","jatuh_tempo","id_submit_invoice"
        );
        $where = array(
            "sisa_waktu <=" => 5
        );
        $result = selectRow("tagihan_customer",$where,$field);
        $data["tagihan_customer"] = $result->result_array();

        $field = array(
            "no_invoice","no_refrence","total","peruntukan_tagihan","rekening_pembayaran","dateline_invoice","sisa_waktu","mata_uang","id_tagihan"
        );
        $where = array(
            "sisa_waktu <=" => 5
        );
        $result = selectRow("tagihan_vendor",$where,$field);
        $data["tagihan_vendor"] = $result->result_array();
        for($a = 0; $a<count($data["tagihan_vendor"]); $a++){
            switch($data["tagihan_vendor"][$a]["peruntukan_tagihan"]){
                case "SUPPLIER":
                $id_supplier = get1Value("po_core","id_supplier",array("no_po" => $data["tagihan_vendor"][$a]["no_refrence"]));
                break;
                case "SHIPPER":
                $id_supplier = get1Value("po_core","id_shipper",array("no_po" => $data["tagihan_vendor"][$a]["no_refrence"]));
                break;
                case "COURIER":
                $id_supplier = get1Value("od_core","id_courier",array("no_od" => $data["tagihan_vendor"][$a]["no_refrence"]));
            }
            $data["tagihan_vendor"][$a]["nama_target"] = get1Value("perusahaan","nama_perusahaan",array("id_perusahaan"=>$id_supplier));
        }

        $this->load->view("req/head");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("req/head-close");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
        /*--------------------------------------------------------*/
        $this->load->view("dashboard/finance",$data);
        /*--------------------------------------------------------*/
        $this->load->view("req/script");
        $this->load->view("req/html-close");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("dashboard/js/finance-js",$data);
        $this->load->view("plugin/datatable/page-datatable-js");
    }
    public function register(){
        $name = array(
            "nama_user",
            "email_user",
            "nohp_user",
            "password"
        );
        $data = array(
            $name[0] => $this->input->post($name[0]),
            $name[1] => $this->input->post($name[1]),
            $name[2] => $this->input->post($name[2]),
            $name[3] => md5($this->input->post($name[3])),
            "id_user_add" => $this->session->id_user
        );
        $this->Mduser->insert($data);
        $this->session->res_msg = "Data Recorded";
        redirect("master/user/employee");
    }
    public function updateJatuhTempoInvoiceCustomer(){
        $where = array(
            "id_submit_invoice" => $this->input->post("id_submit_invoice")
        );
        $data = array(
            "jatuh_tempo" => $this->input->post("updateTanggal".$this->input->post("id_submit_invoice"))
        );
        updateRow("invoice_core",$data,$where);
        redirect("welcome/finance");
    }
    public function updateJatuhTempoTagihanVendor(){
        $where = array(
            "id_tagihan" => $this->input->post("id_tagihan")
        );
        $data = array(
            "dateline_invoice" => $this->input->post("updateTanggal".$this->input->post("id_tagihan"))
        );
        updateRow("tagihan",$data,$where);
        redirect("welcome/finance");
    }
    public function updateJatuhTempoPo(){
        $where = array(
            "id_submit_po" => $this->input->post("id_submit_po")
        );
        $data = array(
            "requirement_date" => $this->input->post("updateTanggal".$this->input->post("id_submit_po"))
        );
        updateRow("po_core",$data,$where);
        redirect("welcome/crm");
    }
    public function updateJatuhTempoQuotationCustomer(){
        $where = array(
            "id_submit_quotation" => $this->input->post("id_submit_quotation")
        );
        $data = array(
            "dateline_quotation" => $this->input->post("updateTanggal".$this->input->post("id_submit_quotation"))
        );
        updateRow("quotation",$data,$where);
        redirect("welcome/crm");
    }
}
?>