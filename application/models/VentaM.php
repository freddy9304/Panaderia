<?php

/**
 *
 */
class VentaM extends CI_Model
{
  public function insert_venta($tipo_venta,$total_venta,$fecha)
  {
    // echo "dentro";die();
    // echo $tipo_venta.' /'.$total_venta.'/ '.$fecha;die();
    $data = array(
    'tipo_venta' => $tipo_venta,
    'fecha_registro' => $fecha,
    'total' => $total_venta,
    );
    $this->db->insert('ventas',$data);
  }

}
