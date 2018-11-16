<?php

/**
 *
 */
class Home extends CI_Controller
{

  public function index($folio_cu=''){
    // die("dentro de index");
      // $this->session->sess_destroy();
      $this->load->model("VentaM");
      $this->load->model('principal');
      $data['result'] = $this->principal->principalModel();
      $data['result_dulce'] = $this->principal->principalModelDulce();
      $data['result_repos'] = $this->principal->principalModelResposteria();
      $data['result_velas'] = $this->principal->principalModelVelas();
      $data['result_leche'] = $this->principal->principalModelLeche();
      $data['result_cafe'] = $this->principal->principalModelCafe();
      $data['result_choco'] = $this->principal->principalModelChoco();
      $data['result_rebanadas'] = $this->principal->principalModelRebanadas();
      $data['result_gelatinas'] = $this->principal->principalModelGelatinas();
      $data['result_pasteles'] = $this->principal->principalModelPasteles();
      $data['result_varios'] = $this->principal->principalModelVarios();
      $folio_cu = $this->input->post('folio_cu');
      $total_cu = $this->input->post('total_cu');
      $abono = $this->input->post('abono');
      $fecha_cu = $this->input->post('fecha_cu');
      // print_r($fecha_cu);die();
      if ($total_cu && $abono) {
        if ($abono==$total_cu) {
          $abono=$total_cu;
          $this->VentaM->boniCancel($folio_cu,$abono,$total_cu);
          $data['contenido'] = 'contenido/principal.phtml';
          $this->load->view('index.phtml',$data);
        }else{
          $data['re'] = $this->VentaM->boniCancel($folio_cu,$abono,$total_cu,$fecha_cu);
          $data['contenido'] = 'contenido/principal.phtml';
          $this->load->view('index.phtml',$data);
        }
      }else{
        $data['re'] = $this->VentaM->boniCancelModel($folio_cu);
        $data['contenido'] = 'contenido/principal.phtml';
        $this->load->view('index.phtml',$data);
      }
  }
  public function user(){
      $data = array('titulo' => 'Inicio de sesión');
      $data['contenido'] = 'contenido/user.phtml';
      $this->load->view('index.phtml',$data);
  }
  public function reposteria(){
    // die("dentro de reposteria");
      $data = array('titulo' => 'Apartado de Reposteria');
      $data['contenido'] = 'contenido/reposteria.phtml';
      $this->load->view('index.phtml',$data);
  }
  // public function boni_cancel(){
  //   $folio_cu = $this->input->post('folio_cu');
  //   // $data = array('titulo' => 'Apartado de Reposteria');
  //   $data['result'] = $this->VentaM->boniCancelModel($folio_cu);
  //   // $data['contenido'] = 'contenido/principal.phtml';
  //   // $this->load->view('index.phtml',$data);
  // }
}
