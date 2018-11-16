<?php

/**
 *
 */
class Excel_export_model extends CI_Model
{

  public function fetch_data($type_venta,$fec1,$fec2)
  {
    // echo $fec1.' model '.$fec2;die();
    if ($type_venta=='all') {
      $filters = $fec1 ? " and fecha_registro BETWEEN '{$fec1}' and '{$fec2}'":' ';
      $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filters}");
    }elseif ($type_venta=='Pedidos_pasteles') {
      $filter = $type_venta ? " and tipo_venta = 'Pedidos_pasteles'":'';
      $this->db->select("*")->from("ventas_pasteles")->where("isDelete = 0 {$filter}");
    }else{
      $filters = $fec1 ? " and fecha_registro BETWEEN '{$fec1}' and '{$fec2}'":' ';
      $filter = $type_venta ? " and tipo_venta = '{$type_venta}'":'';
      $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filter} {$filters}");
    }
  $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
      }else{
      return null;
    }
  }
}
