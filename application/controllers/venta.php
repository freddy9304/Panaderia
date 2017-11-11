<?php
/**
 *
 */
class Venta extends CI_Controller
{
    public function insertar_venta(){
          $this->load->model("VentaM");
          $total_venta = $this->input->post('total_venta');
          $total_venta_paste = $this->input->post('total_venta_paste');
         	$fecha = date('Y-m-d H:i:s');
          if ($total_venta_paste) {
            $tipo_venta = 'Pasteleria';
            $this->VentaM->insert_venta($tipo_venta,$total_venta_paste, $fecha);
          }else{
            $tipo_venta = 'General';
            $this->VentaM->insert_venta($tipo_venta,$total_venta, $fecha);
          }
          // $this->venta->insert_venta($total_venta,$fecha);
          redirect(BASE_URL);
    }
}
