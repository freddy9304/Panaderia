<?php
/**
 *
 */
class Venta extends CI_Controller
{
    public function insertar_venta(){
      date_default_timezone_set("America/Mexico_City");
          $this->load->model("VentaM");
          $total_venta = $this->input->post('total_venta');
          $total_venta_paste = $this->input->post('total_venta_paste');
          $total_venta_nom = $this->input->post('total_venta_nom');
          $total_venta_dir = $this->input->post('total_venta_dir');
          $total_venta_correo = $this->input->post('total_venta_correo2');
          $total_venta_espe = $this->input->post('total_venta_espe2');
          $total_venta_relle = $this->input->post('total_venta_relle');
          $total_venta_base = $this->input->post('total_venta_base');
          $total_venta_anti = $this->input->post('total_venta_anti');
          $total_venta_num = $this->input->post('total_venta_num');
          $total_venta_cel = $this->input->post('total_venta_cel');
          $total_venta_can = $this->input->post('total_venta_can');
         	$fecha = date('Y-m-d H:i:s');
          if ($total_venta_paste) {
            $sustituir = array(" ",":","-");
            $folio = str_replace($sustituir,"",$fecha).'-'.$total_venta_paste;
            $tipo_venta1 = 'Pasteleria';
            $this->VentaM->insert_venta($tipo_venta1,$total_venta_paste, $fecha,$folio);
            $tipo_venta2 = 'Pedidos_pasteles';
            // print_r($tipo_venta2);die();
            // echo "clase: ".$total_venta_correo;
            $this->VentaM->insert_venta_pasteleria($tipo_venta2,$total_venta_nom, $total_venta_dir,$total_venta_num,$total_venta_relle,$total_venta_can,$total_venta_paste,$total_venta_espe,$total_venta_correo,$total_venta_cel,$total_venta_anti,$total_venta_base,$folio);
            redirect(BASE_URL);
          }else{
            $sustituir = array(" ",":","-");
            $folio = str_replace($sustituir,"",$fecha).'-'.$total_venta;
            $tipo_venta = 'Panes';
            $this->VentaM->insert_venta($tipo_venta,$total_venta, $fecha,$folio);
            redirect(BASE_URL);
          }
          // $this->venta->insert_venta($total_venta,$fecha);
    }

}
