<?php


/**
 *
 */
 class Tabla extends CI_Controller
 {

   public function index(){
     $this->load->model("Excel_export_model");
     $this->load->model('tablaModel');
     $type_venta = $this->input->post('type_venta');
     $fechas1 = $this->input->post('fechas1');
     $fechas2 = $this->input->post('fechas2');
     // print_r($fechas1);die();
     // $data['que'] = $type_venta;
     $data = array('titulo' => 'Listado de Ventas');
     $data['contenido'] = 'contenido/tabla.phtml';
     $data['ventas_all'] = $this->Excel_export_model->fetch_data($type_venta,$fechas1,$fechas2);
     $data['general'] = $type_venta;
     $data['fe1'] = $fechas1;
     $data['fe2'] = $fechas2;
     $data['result'] = $this->tablaModel->getVentasAll($type_venta,$fechas1,$fechas2);
     // print_r($type_venta);
     $this->session->set_userdata($data);
     $this->load->view('index.phtml',$data);
     return get_defined_vars();
     // $this->load->view('index.phtml', $datos);
   }
}
