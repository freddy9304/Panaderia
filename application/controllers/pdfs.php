<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdfs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pdfs_model');
        $this->load->model('tablaModel');
    }

    public function index()
    {
        //$data['provincias'] llena el select con las provincias españolas
        $data['ven'] = $this->pdfs_model->getVentasPdf();
        //cargamos la vista y pasamos el array $data['provincias'] para su uso
        $this->load->view("index.phtml",$data);
    }

    public function generar($general='',$fe1='',$fe2='') {
        $url = BASE_URL;
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Daniel Alfredo');
        $pdf->SetTitle('Total de ventas');
        $pdf->SetSubject('Tutorial de pdf ');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(0, 0, 0),array(0, 0, 0));
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);

// Establecer el tipo de letra

//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('helvetica', '', 10, '', true);

// Añadir una página
// Este método tiene varias opciones, consulta la documentación para más información.
        // $pdf->AddPage();
        $pdf->AddPage('L', 'A4');
        // $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Establecemos el contenido para imprimir
        $type_venta = $general;
        $fec1 = $fe1;
        $fec2 = $fe2;

        // print_r($type_venta);die();

        $ventapdf = $this->pdfs_model->getVentasSeleccionadas($type_venta,$fec1,$fec2);
        // echo "<pre>";
        // print_r($ventapdf);
        // echo "</pre>";die();
        // die();
        // foreach($provincias as $fila)
        // {
        //     $prov = $fila['p.provincia'];
        // }
        $total_general = 0;
        $html = "";
        $html .= "<link rel='stylesheet' type='text/css' href='../assets/css/bootstrap.min.css' >";
        $html .="<style>
                    .all{
                      background-color:rgb(0, 255, 90);
                      background-size:contain;
                    }
                  </style>";
        //preparamos y maquetamos el contenido a crear
        $html .= "<h2 style='font-size:35em;'>Ventas de la Panaderia San Miguel</h2>";
        $html .= "<div class='all table-responsive'>";
        $html .= "<table class='table table-striped' width='100%'>";
        if ($type_venta=="Pedidos_pasteles") {
                    $html .= "<tr>
                    <th>#</th>
                    <th>Tipo de Venta</th>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Telefono</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Especificaciones</th>
                    <th>Relleno</th>
                    <th>Cantidad (kg)</th>
                    <th>Base</th>
                    <th>Anticipo</th>
                    <th>Total de Venta</th>
                    </tr>";

                    foreach ($ventapdf as $fila)
                    {
                      // print_r($fila);die();
                      $id = $fila->idventas_pasteles;
                      $tipo_ventapdf = $fila->tipo_venta;
                      $no = $fila->nombre;
                      $di = $fila->direccion;
                      $te = $fila->telefono;
                      $ce = $fila->celular;
                      $co = $fila->correo;
                      $es = $fila->especificaciones;
                      $re = $fila->relleno;
                      $ca = $fila->cantidad;
                      $ba = $fila->base;
                      $an = $fila->anticipo;
                      $to = $fila->total;

                      $html .= "<tr><td class='id'>" . $id . "</td><td class='tipo_venta'>" . str_replace("_"," ",$tipo_ventapdf)  . "</td><td class='nombre'>" . $no . "</td><td class='direccion'>" . $di . "</td>
                      <td class='telefono'>" . $te . "</td><td class='celular'>" . $ce . "</td><td class='correo'>" . $co . "</td><td class='especificaciones'>" . $es . "</td>
                      <td class='relleno'>" . $re . "</td><td class='cantidad'>" . $ca . "</td><td class='base'>" . $ba . "</td><td class='anticipo'>" . $an . "</td><td class='total'>" . $to . "</td></tr>";
                      $total_general+=$to;
                      // $total_general+=$to;
                    }
        }elseif($type_venta=='all' || $type_venta=='Panes' || $type_venta='Pasteleria') {
          $html .= "<tr>
                      <th colspan='2' >#</th>
                      <th>Tipo de Venta</th>
                      <th>Fecha de Venta</th>
                      <th>Estatus</th>
                      <th>Tipo de Pago</th>
                      <th>Total de Venta</th>
                    </tr>";
                    // echo "<pre>";
                    // print_r($ventapdf);
                    // echo "</pre>";
                    foreach ($ventapdf as $fila)
                    {
                        $id = $fila->id;
                        $tipo_ventapdf = $fila->tipo_venta;
                        $fe = $fila->fecha_registro;
                        $to = $fila->total;

                        $html .= "<tr>
                                    <td class='id'>" . $id . "</td>
                                    <td class='tipo_venta'>" . $tipo_ventapdf . "</td>
                                    <td class='fecha'>" . $fe . "</td>
                                    <td class='estatus'>" . ($fila->confirm==1?'Liquidado':'Pendiente') . "</td>
                                    <td class='tipo_pago'>" . ($fila->tipo_pago==0?'No pagado':($fila->tipo_pago==1?'Efectivo':'Tarjeta')) . "</td>
                                    <td class='total'>" . $to . "</td>
                                  </tr>";
                        $total_general+=$to;
                        // print_r($total_general);die();
                    }
        }
        // $html .="hola perro";
        if ($type_venta=='Pasteleria2') {
          $html .= "<tr><td>Total de ventas generales</td><td></td><td></td><td></td><td></td><td>".$total_general."</td></tr>";
        }elseif($type_venta=='all' || $type_venta=='Panes' || $type_venta=='Pasteleria'){
          $html .= "<tr><td>Total de ventas generales</td><td></td><td></td><td></td><td></td><td>".$total_general."</td></tr>";
        }
        // $html .= "<tr><td class='id'>Total general</td><td class='tipo_venta'></td><td class='tipo_venta'></td><td class='total'>" . $total_general . "</td></tr>";
        //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
        $html .= "</table>";
        $html .= "</div>";
        // print_r($html);die();
        //$html .= "<div style='background-image: url('../../assets/img/fondo.png')' height='350px' width='100%'>";
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        // $pdf->Image($url.'assets/img/bienvenida.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// Imprimimos el texto con writeHTMLCell()
        // $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Reporte.pdf");
        $pdf->Output($nombre_archivo, 'D');
    }


  public function generar_new() {
            $url = BASE_URL;
            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Daniel Alfredo');
            $pdf->SetTitle('Total de ventas');
            $pdf->SetSubject('Tutorial de pdf ');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(0, 0, 0),array(0, 0, 0));
            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
            $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//relación utilizada para ajustar la conversión de los píxeles
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// establecer el modo de fuente por defecto
      $pdf->setFontSubsetting(true);

// Establecer el tipo de letra

//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
// Helvetica para reducir el tamaño del archivo.
      $pdf->SetFont('freemono', '', 14, '', true);

// Añadir una página
// Este método tiene varias opciones, consulta la documentación para más información.
      $pdf->AddPage();

      // //fijar efecto de sombra en el texto
              $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Establecemos el contenido para imprimir
      // $provincia = $this->input->post('provincia');
      $type_venta ='General';
      $pdf_venta = $this->pdfs_model->getVentasSeleccionadas($type_venta);
      $total_general = 0;
      // foreach($pdf_venta as $fila)
      // {
      //     $prov = $fila['p.provincia'];
      // }
      //preparamos y maquetamos el contenido a crear
      $html = '';
      $html .= "<style type=text/css>";
      $html .= "th{color: #fff; font-weight: bold; background-color: #222}";
      $html .= "td{background-color: #AAC7E3; color: #fff}";
      $html .= "</style>";
      // $html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($pdf_venta)." localidades</h4>";
      $html .= "<table width='100%'>";
      $html .= "<tr><th>#</th><th>Tipo de Venta</th><th>Fecha de Venta</th><th>Total de Venta</th></tr>";

      //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
      foreach ($pdf_venta as $fila)
      {
          // $id = $fila['l.id'];
          // $localidad = $fila['l.localidad'];

          $html .= "<tr><td class='id'>" . $fila->id . "</td><td class='tipo_venta'>" . $fila->tipo_venta . "</td><td class='fecha'>" . $fila->fecha_registro . "</td><td class='total'>" . $fila->total . "</td></tr>";
          // $total_general+=$fila->total;
      }
      // $html .= "<tr><td class='id'>Total general</td><td class='tipo_venta'></td><td class='tipo_venta'></td><td class='tipo_venta'></td><td class='tipo_venta'></td><td class='tipo_venta'></td><td class='fecha'></td><td class='total'>" . $total_general . "</td></tr>";
      $html .= "</table>";

// Imprimimos el texto con writeHTMLCell()
      $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
      $nombre_archivo = utf8_decode("Localidades");
      $pdf->Output($nombre_archivo, 'I');
  }
}
