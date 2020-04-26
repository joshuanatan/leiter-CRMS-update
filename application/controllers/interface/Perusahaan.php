<?php 
class Perusahaan extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function insertSupplier(){
        $data = $this->input->post("supplier_data"); /*list formnya*/
        $id_perusahaan = insertRow("perusahaan",$data);
        echo json_encode($id_perusahaan);
    }
    public function getAlamatPerusahaan($id_perusahaan){
        $tipe_variable = $this->input->post("tipe_variable");
        if($tipe_variable == "id_harga_vendor"){
            $id_perusahaan = get1Value("harga_vendor","id_perusahaan",array("id_harga_vendor" => $id_perusahaan));
        }
        $where = array(
            "id_perusahaan" => $id_perusahaan
        );
        $alamat_perusahaan = get1Value("perusahaan","alamat_perusahaan",$where);
        echo json_encode($alamat_perusahaan);
    }
    public function getDetailPerusahaan($id_perusahaan){
        $where = array(
            "id_perusahaan" => $id_perusahaan
        );
        $field = array(
            "nama_perusahaan","nofax_perusahaan","alamat_perusahaan","notelp_perusahaan","peran_perusahaan","jenis_perusahaan"
        );
        $result = selectRow("perusahaan",$where);
        $data = foreachResult($result,$field,$field);
        echo json_encode($data);
    }
    public function getPerusahaanFromOc(){
        $where = array(
            "id_submit_oc" => $this->input->post("id_submit_oc")
        );
        $id_submit_quotation = get1Value("order_confirmation","id_submit_quotation",$where);
        $id_submit_request = get1Value("quotation","id_request",array("id_submit_quotation" => $id_submit_quotation));
        $id_perusahaan = get1Value("price_request","id_perusahaan",array("id_submit_request" => $id_submit_request));
        $this->getDetailPerusahaan($id_perusahaan);
    }
    public function searchCustomerByName(){ //dipake di visit report buat nyari nama perusahaan
        
        $sql = "
            select 
                nama_perusahaan, 
                perusahaan.id_perusahaan,
                contact_person.nama_cp, 
                id_cp from perusahaan
            inner join contact_person
                on contact_person.id_perusahaan = perusahaan.id_perusahaan
            where perusahaan.status_perusahaan = 0 and 
            peran_perusahaan = 'CUSTOMER' and 
            nama_perusahaan like '%".$this->input->post("nama_perusahaan")."%'
            group by perusahaan.id_perusahaan";
        $result = executeQuery($sql);
        $field = array(
            "nama_perusahaan","id_perusahaan","nama_cp","id_cp"
        );
        $data = foreachMultipleResult($result,$field,$field);
        echo json_encode($data);
    }
}