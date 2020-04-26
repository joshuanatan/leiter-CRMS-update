<?php
class main extends CI_Controller{
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
        $this->load->view("plugin/wysiwyg/wysiwyg-css");
        $this->load->view("req/head-close");
        $this->load->view("report/report-open");
        $this->load->view("req/top-navbar");
        $this->load->view("req/navbar");
    }
    public function close(){
        $this->load->view("req/script");
        $this->load->view("report/main/js/request-ajax");
        $this->load->view("plugin/datatable/page-datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/tabs/tabs-js");
        $this->load->view("plugin/chart-js/chart-js-js");
        $this->load->view("report/report-close");
        $this->load->view("req/html-close"); 
    }
    public function index(){
        /*load detail kpi user*/
        /*ngambil kpi user yang udah diset buat orang yang lagi login*/
        
        $where = array(
            "id_user" => $this->session->id_user,
            "status_aktif_kpi" => 0
        );
        
        $field = array(
            "id_user","kpi","id_kpi_user"
        );
        $result = selectRow("kpi_user",$where,$field);
        $data["kpi_user"] = $result->result_array();

        $where = array(
            "id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_report")) == 0){
            $where = array(
                "id_user_add" => $this->session->id_user,
                "status_aktif_report" => 0
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_report")) == 0){
            $where = array(
                "status_aktif_report" => 0
            );
        }
        $field = array(
            "id_report","tipe_report","pic_target","location","progress_percentage","report","tgl_report","judul_report","attachment","support_need","next_plan","kpi","week_name"
        );
        $result = selectRow("detail_kpi_user",$where,$field);
        $data["kpi_report"] = $result->result_array();
        
        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/main/category-header");
        $this->load->view("report/main/category-body",$data);
        $this->load->view("report/content-close");
        $this->close();
    }
    public function insertReport(){
        $where = array(
            "tgl_mulai <= " => date("Y-m-d"), 
            "tgl_selesai >= " => date("Y-m-d") 
        );
        $id_week = get1Value("report_weeks","id_weeks",$where);
        $config = array(
            "upload_path" => "./assets/dokumen/report/",
            "allowed_types" => "jpg|png|jpeg|gif|docx|doc|pdf|xls|xlsx"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
        }
        else{
            $fileData["file_name"] ="-";
        }
        $data = array(
            "tipe_report" => $this->input->post("tipe_report"),
            "pic_target" => $this->input->post("pic_target"),
            "location" => $this->input->post("location"),
            "progress_percentage" => $this->input->post("progress_percentage"),
            "report" => $this->input->post("report"),
            "judul_report" => $this->input->post("judul_report"),
            "attachment" => $fileData["file_name"],
            "support_need" => $this->input->post("support_need"),
            "id_user_add" => $this->session->id_user,
            "next_plan" => $this->input->post("next_plan"),
            "id_week" => $id_week
        );
        insertRow("report",$data);
        redirect("report/main");
    }
    public function updateReport($id_report){
        $where = array(
            "id_report" => $id_report
        );
        $config = array(
            "upload_path" => "./assets/dokumen/report/",
            "allowed_types" => "jpg|png|jpeg|gif|docx|doc|pdf|xls|xlsx"
        );
        $this->load->library("upload",$config);
        if($this->upload->do_upload("attachment")){
            $fileData = $this->upload->data();
            $data = array(
                "tipe_report" => $this->input->post("tipe_report") ,
                "pic_target" => $this->input->post("pic_target") ,
                "location" => $this->input->post("location") ,
                "progress_percentage" => $this->input->post("progress_percentage") ,
                "report" => $this->input->post("report") ,
                "judul_report" => $this->input->post("judul_report") ,
                "attachment"=> $fileData["file_name"],
                "support_need" => $this->input->post("support_need"),
                "next_plan" => $this->input->post("next_plan"),
            );
        }
        else{
            $data = array(
                "tipe_report" => $this->input->post("tipe_report") ,
                "pic_target" => $this->input->post("pic_target") ,
                "location" => $this->input->post("location") ,
                "progress_percentage" => $this->input->post("progress_percentage") ,
                "report" => $this->input->post("report") ,
                "judul_report" => $this->input->post("judul_report") ,
                "support_need" => $this->input->post("support_need"),
                "next_plan" => $this->input->post("next_plan"),
            );
        }
        
        updateRow("report",$data,$where);
        redirect("report/main/");
    }
    public function remove($id_report){
        $where = array(
            "id_report" => $id_report
        );
        $data = array(
            "status_aktif_report" => 1
        );
        updateRow("report",$data,$where);
        redirect("report/main");
    }

    public function report(){ /*nampilin visit report yang udah di submit oleh orang yang lagi login*/
        $where = array(
            "id_user_add" => -999
        );
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_created_visit")) == 0){
            $where = array(
                "id_user_add" => $this->session->id_user,
                "status_aktif_report" => 0
            );
        }
        if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "view_all_visit")) == 0){
            $where = array(
                "status_aktif_report" => 0
            );
        }
        $field = array(
            "id_submit_report", "action_date", "id_perusahaan", "action_location", "action_duration", "action_purpose", "action_pic", "action_conversation", "potential_machine", "action_conclusion", "action_percentage_order", "support_need", "followup_date", "id_user_add", "tgl_report_add", "status_aktif_report", "status_cetak_report", "jenis_report","conversation_image","nama_perusahaan","jenis_report"
        );
        
        $result = selectRow("detail_visit_call_report",$where,$field);
        $data["visit"] = $result->result_array();
        for($a = 0; $a<count($data["visit"]); $a++){
            
            $where = array(
                "id_submit_report" => $data["visit"][$a]["id_submit_report"],
                "status_next_action" => 0
            );  
            $result = selectRow("visit_call_report_next_action",$where);
            $field = array(
                "id_submit_next_action","remarks","pic","status_next_action"
            );  
            $data["visit"][$a]["next_action"] = foreachMultipleResult($result,$field,$field);
        }
        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/main/visit-header");
        $this->load->view("report/main/visit-report",$data);
        $this->load->view("report/content-close");
        $this->close();
        $this->load->view("plugin/wysiwyg/wysiwyg-js");
    }
    public function insertVisitCallReport(){
        if($this->session->id_user == "") redirect("login/welcome");
        $data = array(
            "id_perusahaan" => $this->input->post("id_perusahaan") ,
            "action_date" => $this->input->post("action_date") ,
            "action_location" => $this->input->post("action_location") ,
            "action_duration" => $this->input->post("action_duration") ,
            "action_purpose" => $this->input->post("action_purpose") ,
            "action_pic" => $this->input->post("action_pic") ,
            "pic_position" => $this->input->post("pic_position") ,
            "action_conversation" => $this->input->post("conversation") ,
            "conversation_image" => "-",
            "potential_machine" => $this->input->post("potential_machine") ,
            "action_conclusion" => $this->input->post("action_conclusion") ,
            "action_percentage_order" => $this->input->post("action_percentage_order") ,
            "support_need" => $this->input->post("support_need") ,
            "followup_date" => $this->input->post("followup_date") ,
            "id_user_add" => $this->session->id_user,
            "jenis_report" => $this->input->post("jenis_report")
        );
        $id_submit_report = insertRow("visit_call_report",$data);

        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $checked){
                $data = array(
                    "remarks" => $this->input->post("remarks".$checked),
                    "pic" => $this->input->post("pic".$checked),
                    "id_submit_report" => $id_submit_report
                );
                insertRow("visit_call_report_next_action",$data);
            }
        }
        $countfiles = count($_FILES['conversation_image']['name']);
        for($i=0;$i<$countfiles;$i++){
   
            if(!empty($_FILES['conversation_image']['name'][$i])){
                $_FILES['file']['name'] = $_FILES['conversation_image']['name'][$i];
                $_FILES['file']['type'] = $_FILES['conversation_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['conversation_image']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['conversation_image']['error'][$i];
                $_FILES['file']['size'] = $_FILES['conversation_image']['size'][$i];
        
                $config['upload_path'] = './assets/report/visit/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['file_name'] = $_FILES['conversation_image']['name'][$i];
    
                //Load upload library
                $this->load->library('upload',$config); 
    
                // File upload
                if($this->upload->do_upload('file')){
                // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data = array(
                        //"id_submit_attachment" => "", //auto increment
                        "attachment" => $filename,
                        "id_submit_report" => $id_submit_report
                    );
                    insertRow("visit_call_report_attachment",$data);
                }
            }
        }
        redirect("report/main/report");
    }
    public function editVisitCallReport($id_submit_report){
        $where = array(
            "id_submit_report" => $id_submit_report
        );
        $field = array(
            "action_date","id_perusahaan","action_location","action_duration","action_purpose","action_pic","pic_position","action_conversation","potential_machine","action_conclusion","action_percentage_order","support_need","followup_date","jenis_report","nama_perusahaan","tgl_report_add","id_submit_report"
        );
        $result = selectRow("detail_visit_call_report",$where,$field);
        $data["report"] = $result->result_array();
 
        $field = array(
            "id_submit_attachment","attachment","id_submit_report"
        );
        $result = selectRow("visit_call_report_attachment",$where,$field);
        $data["attachment"] = $result->result_array();
        $field = array(
            "id_submit_next_action","remarks","pic","id_submit_report","status_next_action",
        );
        $result = selectRow("visit_call_report_next_action",$where,$field);
        $data["next_action"] = $result->result_array();

        $this->req();
        $this->load->view("report/content-open");
        $this->load->view("report/main/category-header");
        $this->load->view("report/main/edit-visit-call-report",$data);
        $this->load->view("report/content-close");
        $this->close();
    }
    public function updateVisitReport(){
        $where = array(
            "id_submit_report" => $this->input->post("id_submit_report")
        );
        $data = array(
            "id_perusahaan" => $this->input->post("id_perusahaan"),
            "action_date" => $this->input->post("action_date"),
            "action_location" => $this->input->post("action_location"),
            "action_duration" => $this->input->post("action_duration"),
            "action_purpose" => $this->input->post("action_purpose"),
            "action_pic" => $this->input->post("action_pic"),
            "pic_position" => $this->input->post("pic_position"),
            "action_conversation" => $this->input->post("conversation"),
            "potential_machine" => $this->input->post("potential_machine"),
            "action_conclusion" => $this->input->post("action_conclusion"),
            "action_percentage_order" => $this->input->post("action_percentage_order"),
            "support_need" => $this->input->post("support_need"),
            "followup_date" => $this->input->post("followup_date"),
            "jenis_report" => $this->input->post("jenis_report")
        );
        updateRow("visit_call_report",$data,$where);

        $checks = $this->input->post("checks");
        $delete = $this->input->post("delete");
        if($checks != ""){
            $config['upload_path'] = './assets/report/visit/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';

            $this->load->library('upload',$config); 

            foreach($checks as $checked){
                $id_submit_attachment = $this->input->post("id_submit_attachment".$checked);
                if($id_submit_attachment != ""){
                    if($this->upload->do_upload('upload'.$checked)){ /*kalau ada yang dicentang dan diupload*/
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        
                        $where = array(
                            "id_submit_attachment" => $id_submit_attachment
                        );
                        $data = array(
                            "attachment" => $filename,
                        );
                        updateRow("visit_call_report_attachment",$data,$where);
                    }
                }
                else{
                    if($this->upload->do_upload('upload'.$checked)){ /*kalau ada yang dicentang dan diupload*/
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        $data = array(
                            "attachment" => $filename,
                            "id_submit_report" => $this->input->post("id_submit_report")
                        );
                        insertRow("visit_call_report_attachment",$data);
                    }
                }
            }
        }
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_submit_attachment" => $deleted
                );
                deleteRow("visit_call_report_attachment",$where);
            }
        }

        $checks = $this->input->post("checks_next_action");
        $delete = $this->input->post("delete_next_action");
        if($checks != ""){
            foreach($checks as $checked){
                $id_submit_next_action = $this->input->post("id_submit_next_action".$checked);
                if($id_submit_next_action != ""){
                    $where = array(
                        "id_submit_next_action" => $id_submit_next_action
                    );
                    $data = array(
                        "remarks" => $this->input->post("remarks".$checked),
                        "pic" => $this->input->post("pic".$checked),
                    );
                    updateRow("visit_call_report_next_action",$data,$where);
                }
                else{
                    $data = array(
                        "remarks" => $this->input->post("remarks".$checked),
                        "pic" => $this->input->post("pic".$checked),
                        "id_submit_report" => $this->input->post("id_submit_report"),
                        "status_next_action" => 0
                    );
                    insertRow("visit_call_report_next_action",$data);
                }
            }
        }
        if($delete != ""){
            foreach($delete as $deleted){
                $where = array(
                    "id_submit_next_action" => $deleted
                );
                deleteRow("visit_call_report_next_action",$where);
            }
        }
        redirect("report/main/editVisitCallReport/".$this->input->post("id_submit_report"));
    }
    public function removeVisitReport($id_submit_report){
        $where = array(
            "id_submit_report" => $id_submit_report
        );  
        $data = array(
            "status_aktif_report" => 1
        );
        updateRow("visit_call_report",$data,$where);
        redirect("report/main/report");
    }
    public function pdfVisitReport($id_submit_report){
        $where = array(
            "id_submit_report" => $id_submit_report
        );
        $field = array(
            "id_submit_report", "action_date", "id_perusahaan", "action_location", "action_duration", "action_purpose", "action_pic", "pic_position", "action_conversation", "potential_machine", "action_conclusion", "action_percentage_order", "support_need", "followup_date", "id_user_add", "tgl_report_add", "status_aktif_report", "status_cetak_report", "jenis_report","conversation_image","nama_perusahaan"
        );
        
        $result = selectRow("detail_visit_call_report",$where,$field);
        $data["visit"] = $result->result_array();
        
        $where = array(
            "id_submit_report" => $id_submit_report,
            "status_next_action" => 0
        );  
        $field = array(
            "id_submit_next_action","remarks","pic","status_next_action"
        );
        $result = selectRow("visit_call_report_next_action",$where,$field);  

        $data["next_action"] = $result->result_array();
        $data["visit"]["sales_name"] = get1Value("user","nama_user",array("id_user" => $data["visit"][0]["id_user_add"]));

        $date = date_create($data["visit"][0]["action_date"]);
        $data["visit"]["action_date"] = date_format($date,"D d-m-Y");
        $date = date_create($data["visit"][0]["followup_date"]);
        $data["visit"]["followup_date"] = date_format($date,"D d-m-Y");
        $split = explode(":",$data["visit"][0]["action_duration"]);
        $data["visit"]["action_duration"] = $split[0]." Jam ".$split[1]." Menit";

        $where = array(
            "id_submit_report" => $id_submit_report
        );
        $field = array(
            "attachment"
        );
        $result = selectRow("visit_call_report_attachment",$where,$field);
        $data["attachment"] = $result->result_array();
        $this->load->view("report/main/pdf-visit-report",$data);
    }
}