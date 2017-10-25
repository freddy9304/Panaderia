<?php

/**
 *
 */
class VentaM extends CI_Model
{
  public function insert_venta($total_venta,$fecha)
  {
    // echo "dentro";die();
    // echo $total_venta.' '.$fecha;die();
    $data = array(
    'tipo_venta' => 'General',
    'fecha_registro' => $fecha,
    'total' => $total_venta,
    );
    $this->db->insert('ventas',$data);
  }

}
