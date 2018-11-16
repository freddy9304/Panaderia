<?php

/**
 *
 */
class buscarModel extends CI_Model
{
  public function folioBuscar($folio){
    // echo "modelo: ".$folio;die();
    $result = $this->db->query("SELECT id,tipo_venta, fecha_registro,total,folio FROM ventas where folio = '".$folio."' AND confirm=0");
    // print_r($this->db->last_query());
    if ($result->num_rows() > 0) {
      return $result->row();
    }else{
      // echo "dentro";
      return null;
    }
  }
  public function folioConfirmar($folio,$optradio){
    // echo "modelo; ".$optradio;die();
          // $result = $this->db->query("UPDATE ventas SET confirm = 1 WHERE folio = '".$folio."'");
          // if ($result->num_rows() > 0) {
          //   return $result->row();
          // }else{
          //   return null;
          // }
          $data = array(
            'confirm' => 1,
            'tipo_pago' => $optradio,
        );
          $this->db->where('folio', $folio);
        return $this->db->update('ventas', $data);
  }
}
