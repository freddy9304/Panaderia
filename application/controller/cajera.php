<?php

/**
 *
 */
class Cajera extends CI_Controller
{


    public function index(){
      $folio = $this->input->post('folio')!==null?$this->input->post('folio'):'';
      // die("dentro de index".$folio);
      $foliohola = $this->input->post('folio_cambio');
      $optradio = $this->input->post('cliente_paga')!=''?$this->input->post('cliente_paga'):$this->input->post('optradio');
      $cliente_paga = $this->input->post('cliente_paga');
      $this->load->model('buscarModel');
      $data['result'] = $this->buscarModel->folioBuscar($folio);
      $data['resulta'] = $this->buscarModel->folioConfirmar($foliohola,$optradio);
      if ($data['result']==null) {
        // echo '<script language="javascript">alert("juas");</script>';
      }else{
      }
      $data['contenido'] = 'contenido/cajera.phtml';
      $this->load->view('index.phtml',$data);
      // print_r($data['resulta']);
      // if($data['resulta']==1){
        // $this->session->set_flashdata('actualizado', 'El mensaje se actualizó correctamente');
      // }
    }
}
