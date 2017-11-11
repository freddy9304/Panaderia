<?php

/**
 *
 */
class tablaModel extends CI_Model
{

  public function getVentas(){
    $result = $this->db->query("SELECT * from ventas where isDelete = 0");
    // print_r($result);die();
    if ($result->num_rows() > 0) {
      return $result->row();
    }else{
      return null;
    }
  }
  public function getVentasAll($type_venta){
    // print_r($type_venta);
    if ($type_venta=='all') {
      $this->db->select("*")->from("ventas")->where("isDelete = 0");
    }else{
      $filter = $type_venta ? " and tipo_venta = '{$type_venta}'":'';
      $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filter}");
    }
  $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
      }else{
      return null;
    }
    // print_r($query);
  }
}
