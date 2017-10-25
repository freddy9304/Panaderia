<?php
/**
 *
 */
class Venta extends CI_Controller
{
    public function insertar_venta(){
          $this->load->model("VentaM");
          $total_venta = $this->input->post('total_venta');
         	$fecha = date('Y-m-d H:i:s') ;
          // $this->venta->insert_venta($total_venta,$fecha);
          $this->VentaM->insert_venta($total_venta, $fecha);
          redirect(BASE_URL);
    }
}
