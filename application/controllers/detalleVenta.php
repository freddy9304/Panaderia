<?php


/**
 *
 */
 class detalleVenta extends CI_Controller
 {

   public function index(){
     $this->load->model("Excel_export_model");
     $this->load->model('tablaModel');
     $type_venta2 = 'Pedidos_pasteles';
     // echo "aqui:".$type_venta2;
     $fechas1 = '';
     $fechas2 = '';
     // $type_venta = $this->input->post('type_venta');
     // $data = array('titulo' => 'Listado de Ventas');
     $data['contenido'] = 'contenido/detalleTabla.phtml';
     $data['ventas_all'] = $this->Excel_export_model->fetch_data($type_venta2,$fechas1,$fechas2);
     $data['general'] = $type_venta2;
     $data['result'] = $this->tablaModel->getDetailsAll($type_venta2);
     // print_r($data[]);die();
     $this->session->set_userdata($data);
     $this->load->view('index.phtml',$data);
     return get_defined_vars();
     // $this->load->view('index.phtml', $datos);
   }

}
