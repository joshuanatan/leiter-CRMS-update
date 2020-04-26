<?php
class Kpi extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function req(){
        $this->load->view("req/head");
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/breadcrumb/breadcrumb-css");
        $this->load->view("plugin/modal/modal-css");
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/chart-widget/chart-widget-css");
        $this->load->view("plugin/chart-js/chart-js-css");
        $this->load->view("req/head-close");
        $this->load->view("report/report-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        //$this->load->view("plugin/chart-widget/chart-widget-js");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("report/report-close");
        $this->load->view("req/html-close"); 
    }
    public function index(){
        /*skenarionya, kan page ini dibuka hari senin / setelahnya*/
        /*insert new week otomatis tiap buka page kpi*/
        $minggu_terdekat = tanggalDariHariTerdekat("sunday",date("Y-m-d"));
        $where = array(
            "tgl_mulai" => tambahHariKeTanggal($minggu_terdekat,1,"day"),
            "tgl_selesai" => tambahHariKeTanggal($minggu_terdekat,5,"day"),
        );
        if(isExistsInTable("report_weeks",$where) == 1){
            $data = array(
                "id_weeks" => getMaxId("report_weeks","id_weeks",array("tahun" => date("Y"))),
                "tahun" => date("Y"),
                "tgl_mulai" => tambahHariKeTanggal($minggu_terdekat,1,"day"),
                "tgl_selesai" => tambahHariKeTanggal($minggu_terdekat,5,"day"),
            );
            insertRow("report_weeks",$data);
        }
        $where = array(
            "tahun" => date("Y")
        );
        $field = array(
            "id_weeks","tgl_mulai","tgl_selesai"
        );
        $result = selectRow("report_weeks",$where,$field);
        $data["week"] = $result->result_array();

        $where = array(
            "status_user" => 0
        );
        $field = array(
            "id_user","nama_user"
        );
        $result = selectRow("user",$where,$field);
        $data["employee"] = $result->result_array();

        $data["maxId"] = getMaxId("report_weeks","id_weeks",array("tahun" => date("Y")));
        
        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/kpi/category-header");
        $this->load->view("report/kpi/category-body",$data);
        $this->load->view("report/content-close");
        $this->close();
    }
    public function user(){
        $where = array(
            "user" => array(
                "status_user" => 0
            )
        );
        $field = array(
            "user" => array(
                "nama_user","email_user","nohp_user","id_user"
            )
        );
        $print = array(
            "user" => array(
                "nama_user","email_user","nohp_user","id_user"
            )
        );
        $result["user"] = selectRow("user",$where["user"]);
        $data["user"] = foreachMultipleResult($result["user"],$field["user"],$print["user"]);

        for($a = 0; $a<count($data["user"]);$a++){
            $where["kpi"] = array(
                "id_user" => $data["user"][$a]["id_user"],
                "status_aktif_kpi" => 0
            );
            $result["kpi"] = selectRow("kpi_user",$where["kpi"]);
            $field["kpi"] = array(
                "kpi","target_kpi","status_aktif_kpi","id_kpi_user"
            );
            $print["kpi"] = array(
                "kpi","target_kpi","status_aktif_kpi","id_kpi_user"
            );
            $data["user"][$a]["kpi"] = foreachMultipleResult($result["kpi"], $field["kpi"],$print["kpi"]);
        }
        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/user/category-header");
        $this->load->view("report/user/category-body",$data);
        $this->load->view("report/content-close");
        $this->close();
    }
    public function weekly($id_weeks){ /*ini udah ngecek peruser*/
        $where = array(
            "id_user_add" => $this->input->post("user"),
            "status_aktif_report" => 0,
            "id_week" => $id_weeks
        );
        $field = array(
            "id_report","tipe_report","pic_target","location","progress_percentage","report","tgl_report","judul_report","attachment","support_need","next_plan","nama_user","week_name"
        );
        $result = selectRow("detail_kpi_user",$where,$field);
        $data["report"] = $result->result_array();
        
        $data["detail"]["nama_user"] = get1Value("user","nama_user",array("id_user" => $this->input->post("user")));
        $data["detail"]["week_name"] = "Week ".$id_weeks;
        $data["detail"]["id_week"] = $id_weeks;
        $where = array(
            "id_user" => $this->input->post("user"),
            "status_aktif_kpi" => 0,
            "target_kpi >" => 0
        );
        $field = array(
            "kpi","target_kpi","id_kpi_user"
        );
        $result = selectRow("kpi_user",$where,$field);
        $data["kpi_user"] = $result->result_array();
        
        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/kpi/category-header");
        $this->load->view("report/kpi/weekly-report",$data);
        $this->load->view("report/content-close");
        $this->close();
        
        $week = $id_weeks;
        $data["kpi_graph"] = array();
        for($a = 0; $a<5; $a++){ /*week 5*/
            for($kpi = 0; $kpi<count($data["kpi_user"]); $kpi++){
                $where = array(
                    "id_weeks" => $week,
                    "id_user_add" => $this->input->post("user"),
                    "tipe_report" => $data["kpi_user"][$kpi]["id_kpi_user"],
                    "tahun" => date("Y")
                );  
                $data["kpi_graph"][$a][$kpi]["report"] = getAmount("detail_kpi_user","id_report",$where); /*week 5, kpi1; week5, kpi2*/
            }
            $data["week"][$a] = $week;
            $week--;
            if($week == 0){
                break;
            }
        }

        $this->load->view("report/kpi/js/chart-js",$data);
    }
    public function insertKpi(){
        /*hapus yang sudah ada dulu*/
        /*delete semua kpi yang orang ini*/
        $checks = $this->input->post("check");
        $delete = $this->input->post("delete");
        
        if($checks != ""){
            
            foreach($checks as $checked){
                //echo $checked;
                $where = array(
                    "id_kpi_user" => $this->input->post("id_kpi_user".$checked)
                );
                if(isExistsInTable("kpi_user",$where) == 0){
                    $where = array(
                        "id_kpi_user" => $this->input->post("id_kpi_user".$checked)
                    );
                    $data = array(
                        "kpi" => $this->input->post("kpi".$checked),
                        "target_kpi" => $this->input->post("target".$checked),
                    );
                    updateRow("kpi_user",$data,$where);
                }
                else{ //kalau belom ad di db pasti kosong gak sih
                    //echo $checked."else";
                    $data = array(
                        "id_kpi_user" => getMaxId("kpi_user","id_kpi_user",array()),
                        "id_user" => $this->input->post("id_user"),
                        "kpi" => $this->input->post("kpi".$checked),
                        "target_kpi" => $this->input->post("target".$checked),
                        "status_aktif_kpi" => 0
                    );
                    insertRow("kpi_user",$data);
                }
            }
        }
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_kpi_user" => $deleted
                );
                $data = array(
                    "kpi" => "",
                    "target_kpi" => 0,
                    "status_aktif_kpi" => 1
                );
                updateRow("kpi_user",$data,$where);
            }
        }
        redirect("report/kpi/user");
        /*aktif non aktif, ikut centang*/
    }
    public function insertWeek(){
        $data = array(
            "id_weeks" => $this->input->post("week_id"),
            "tahun" => date("Y"),
            "tgl_mulai" => $this->input->post("start_date"),
            "tgl_selesai" => $this->input->post("end_date"), 
        );
        insertRow("report_weeks",$data);
        redirect("report/kpi");
    }
}