<?php
class MdPo_item extends CI_Model{
    public function select($where){
        return $this->db->get_where("po_item",$where);
    }
    public function update($data,$where){
        $this->db->update("po_item",$data,$where);
    }
    public function delete($where){
        $this->db->delete("po_item",$where);
    }
    public function insert($data){
        $this->db->insert("po_item",$data);
    }
    public function maxId(){
        $this->db->select("max(id_po) as maxId");
        $row = $this->db->get("po_item");
        foreach($row->result() as $a){
            if($a->maxId != ""){
                return $a->maxId+1;
            }
            else return 1;
        }
    }
    public function selectSupplierShipper($where){
        $this->db->group_by(array("id_supplier","id_shipper","shipping_method"));
        return $this->db->get_where("po_item",$where);
    }
    public function sumSupplier($where){
        $this->db->select("sum(harga_item) as 'total'");
        $this->db->where($where);
        $result = $this->db->get("po_item");
        foreach($result->result() as $a){
            return $a->total;
        }
    }
    public function sumShipper($where){
        $this->db->select("sum(harga_shipping) as 'total'");
        $this->db->where($where);
        $result = $this->db->get("po_item");
        foreach($result->result() as $a){
            return $a->total;
        }
    }
    public function get1Value($coloumn,$where){
        $this->db->select($coloumn);
        $result = $this->db->get_where("po_item",$where);
        foreach($result->result() as $a){
            return $a->$coloumn;
            break;
        }
    }
    public function getItemTypeAmount($where){
        $this->db->select("count(id_po_item) as 'amount'");
        $result = $this->db->get_where("po_item",$where);
        foreach($result->result() as $a){
            return $a->amount;
        }
    }
    /******************************************************************/
    public function getPoItem($id_submit_oc,$id_submit_po,$where,$field){
        $this->db->select($field);
        $this->db->join("po_item","po_item.id_oc_item = order_item_detail.id_oc_item","LEFT OUTER");
        $this->db->where("id_submit_oc",$id_submit_oc);
        $this->db->group_start();
        $this->db->where("id_submit_po",$id_submit_po);
        $this->db->or_where("id_submit_po is null",NULL,FALSE);
        $this->db->group_end();
        return $this->db->get_where("order_item_detail",$where);
    }


}
?>