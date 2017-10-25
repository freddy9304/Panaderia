<?php

/**
 *
 */
class Home extends CI_Controller
{

  public function index(){
    // die("dentro de index");
      // $this->session->sess_destroy();

      $this->load->model('principal');
      $data['result'] = $this->principal->principalModel();
      $data['result_dulce'] = $this->principal->principalModelDulce();
      $data['result_repos'] = $this->principal->principalModelResposteria();
      $data['result_velas'] = $this->principal->principalModelVelas();
      $data['result_leche'] = $this->principal->principalModelLeche();
      $data['result_cafe'] = $this->principal->principalModelCafe();
      $data['result_choco'] = $this->principal->principalModelChoco();
      $data['result_rebanadas'] = $this->principal->principalModelRebanadas();
      $data['contenido'] = 'contenido/principal.phtml';
  		$this->load->view('index.phtml',$data);
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
}
