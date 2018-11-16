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
  public function getVentasAll($type_venta,$fechas1,$fechas2){
    if ($type_venta=='all') {
      $filters = $fechas1 ? " and fecha_registro BETWEEN '{$fechas1}' and '{$fechas2}'":' ';
      $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filters}");
      // echo 'all: '.$filters;
      // print_r($this->db->last_query());
    }else{
      $filters = $fechas1 ? " and fecha_registro BETWEEN '{$fechas1}' and '{$fechas2}'":' ';
      $filter = $type_venta ? " and tipo_venta = '{$type_venta}'":'';
      $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filter} {$filters}");
      // echo $type_venta.': '.$filters;
      // print_r($this->db->last_query());
    }
  $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
      }else{
      return null;
    }
    // print_r($query);
  }
  public function getDetailsAll(){
    // print_r($type_venta);
      $this->db->select("*")->from("ventas_pasteles")->where("isDelete = 0");
      $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->result();
      }else{
      return null;
    }
  }
}
