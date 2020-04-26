<?php
class Contact_person extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("Mdcontact_person");
    }
    /*
    API contact person
    fungsinya: untuk mendapatkan list contact person dari perusahaan tertentu
    parameter: id_perusahaan, all_status.
    return value: id_cp (id contact person), nama_cp (nama contact person), jk_cp (jenis kelamin contact person)
    notes: parameter all_status ditujukan untuk mengetahui preferensi apakah yang statusnya tidak aktif akan ditampilkan atau tidak: default: tidak ditampilkan.

    */
    public function getContactPerson($id_perusahaan,$all_status="false"){
        $where = array();
        if($all_status == "false"){
            $where = array(
                "id_perusahaan" => $id_perusahaan,
                "status_cp" => 0
            );
        }
        else{
            $where = array(
                "id_perusahaan" => $id_perusahaan,
            );
        }
        $field = array(
            "id_cp","nama_cp","jk_cp"
        );
        $result = selectRow("contact_person",$where);
        echo json_encode(foreachMultipleResult($result,$field,$field));
    }
    /*
    fungsi: mendapatkan detail informasi terkait contact person
    parameter: id_cp (id contact person)
    return value = id_cp, nama_cp, jk_cp, email_cp, nohp_cp, jabatan_cp
    */
    public function getDetailContactPerson($id_cp){
        $where = array(
            "id_cp" => $id_cp
        );
        $field = array(
            "id_cp","nama_cp","jk_cp","email_cp","nohp_cp","jabatan_cp"
        );
        $print = array(
            "id_cp","nama_cp","jk_cp","email_cp","nohp_cp","jabatan_cp"
        );
        $result = selectRow("contact_person",$where);
        echo json_encode(foreachResult($result,$field,$print));
    }
    /*method ini biasa dipanggil saat ada pemasukan supplier dan cp baru dengan metode ajax*/
    public function insertContactPerson(){  
        $data = $this->input->post("cp_data");
        $id_cp = insertRow("contact_person",$data);
        echo json_encode($id_cp);
    }
}   

?>