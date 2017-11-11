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
     // print_r($type_venta);die();
     $data = array('titulo' => 'Listado de Ventas');
     $data['contenido'] = 'contenido/tabla.phtml';
     $data['ventas_all'] = $this->Excel_export_model->fetch_data();
     $data['result'] = $this->tablaModel->getVentasAll($type_venta);
     // print_r($data);die();
     $this->session->set_userdata($data);
     $this->load->view('index.phtml',$data);
     // return get_defined_vars();
     // $this->load->view('index.phtml', $datos);
   }
   
}
