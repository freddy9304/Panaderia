<?php

/**
 *
 */
class VentaM extends CI_Model
{
  public function insert_venta($tipo_venta1,$total_venta,$fecha,$folio)
  {
    // echo "dentro";die();
    // echo "modelo: ".$folio;die();
    $data = array(
    'tipo_venta' => $tipo_venta1,
    'fecha_registro' => $fecha,
    'total' => $total_venta,
    'folio' => $folio,
    );
    $this->db->insert('ventas',$data);
  }
  public function insert_venta_pasteleria($tipo_venta2,$total_venta_nom, $total_venta_dir,$total_venta_num,$total_venta_relle,$total_venta_can,$total_venta_paste,$total_venta_espe,$total_venta_correo,$total_venta_cel,$total_venta_anti,$total_venta_base,$folio)
  {
    // echo "dentro";die();
    // echo "modelo: ".$total_venta_correo;die();
    $can =  $total_venta_can.' kg';
    $data = array(
    'tipo_venta' => $tipo_venta2,
    'nombre' => $total_venta_nom,
    'direccion' => $total_venta_dir,
    'telefono' => $total_venta_num,
    'celular' => $total_venta_cel,
    'correo' => $total_venta_correo,
    'especificaciones' => $total_venta_espe,
    'relleno' => $total_venta_relle,
    'cantidad' => $can,
    'base' => $total_venta_base,
    'total' => $total_venta_paste,
    'anticipo' => $total_venta_anti,
    'folio' => $folio
     );
    $this->db->insert('ventas_pasteles',$data);
    // print_r($this->db->last_query());die();
  }
  public function boniCancelModel($folio_cu){
    $result = $this->db->query("SELECT * FROM ventas where folio ='".$folio_cu."'");
    // print_r($this->db->last_query());die();
    if ($result->num_rows() > 0) {
      return $result->row();
    }else{
      return null;
    }
  }
  public function boniCancel($folio_cu,$abono,$total_cu,$fecha_cu){
    if ($abono!=$total_cu) {
      $l = $total_cu-$abono;
      $carac = array(" ",":","-");
      $new_fol = str_replace($carac,"",$fecha_cu).'-'.$l;
      $data = array(
        'bonificacion' => $abono,
        'total'=>$l,
        'folio'=>$new_fol
      );
      $data1 = array(
        'total'=>$l,
        'folio'=>$new_fol
      );
      $this->db->where('folio', $folio_cu);
      $res = array(
        'uno' => $this->db->update('ventas', $data),
        'dos' => $this->db->update('ventas_pasteles', $data1)
      );
      if ($res) {
        return $res;
      }
    }else{
      $data = array(
        'isDelete' => 1
      );
      $this->db->where('folio', $folio_cu);
      return $this->db->update('ventas', $data);
    }
  }

}
