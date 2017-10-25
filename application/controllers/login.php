<?php

/**
 *
 */
class Login extends CI_Controller
{

  public function index ()
  {
    // $data = array('titulo' => 'Listado de Ventas');
    $nick = $this->input->post('usuario');
    $password = $this->input->post('password');

    $this->load->model('user');
    $fila = $this->user->getUser($nick,$password);
    // echo "usuario es: ".$nick." y la contraseña es: ".$password;
    if ($fila != null) {
      if ($fila->password == $password) {
        $data = array(
          'nick' => $nick,
          'id' => $fila->id,
          'login' => TRUE
        );
        $data['contenido'] = 'contenido/user.phtml';
        $this->session->set_userdata($data);
        $this->load->view('index.phtml',$data);
      }else{
        header("Location: " . base_url());
      }
    }else{
      header("Location: " . base_url());
    }



    $this->session->userdata('nick');
  }


  public function logut()
  {
    $this->session->sess_destroy();
    redirect(BASE_URL);
  }

  public function tabla(){
    $this->load->model("Excel_export_model");
    $this->load->model('tablaModel');
    $data = array('titulo' => 'Listado de Ventas');
    $data['contenido'] = 'contenido/tabla.phtml';
    $data['ventas_all'] = $this->Excel_export_model->fetch_data();
    $data['result'] = $this->tablaModel->getVentasAll();
    // print_r($data);die();
    $this->session->set_userdata($data);
    $this->load->view('index.phtml',$data);
    // return get_defined_vars();
    // $this->load->view('index.phtml', $datos);
  }
}
