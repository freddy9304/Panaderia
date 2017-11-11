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
}
