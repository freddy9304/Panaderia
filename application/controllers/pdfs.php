<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdfs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pdfs_model');
    }

    public function index()
    {
        //$data['provincias'] llena el select con las provincias españolas
        $data['ven'] = $this->pdfs_model->getVentasPdf();
        //cargamos la vista y pasamos el array $data['provincias'] para su uso
        $this->load->view("index.phtml",$data);
    }

    public function generar() {
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
        $pdf->AddPage();

//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Establecemos el contenido para imprimir
        // $vent = $this->input->post('ve');
        $ventapdf = $this->pdfs_model->getVentasSeleccionadas();
        // foreach($provincias as $fila)
        // {
        //     $prov = $fila['p.provincia'];
        // }
        $total_general = 0;
        $html = "";
        $html .="<style>
                    .all{
                      background-color:rgb(0, 255, 90);
                      background-size:contain;
                    }
                  </style>";
        //preparamos y maquetamos el contenido a crear
        // $html .= "<style type=text/css>";
        // // $html .= ".all{background-color:red; background-size: contain;}";
        // // $html .= "td{background-color: #AAC7E3; color: #fff}";
        // $html .= "</style>";
        $html .= "<h2 style='font-size:35em;'>Ventas de la Panaderia San Miguel</h2>";
        $html .= "<div class='all'>";
        $html .= "<table width='100%'>";
        $html .= "<tr>
                    <th>#</th>
                    <th>Tipo de Venta</th>
                    <th>Fecha de Venta</th>
                    <th>Total de Venta</th>
                  </tr>";
        //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
        foreach ($ventapdf as $fila)
        {
          // print_r($fila);die();
            $id = $fila->id;
            $tipo_ventapdf = $fila->tipo_venta;
            $fe = $fila->fecha_registro;
            $to = $fila->total;

            $html .= "<tr><td class='id'>" . $id . "</td><td class='tipo_venta'>" . $tipo_ventapdf . "</td><td class='fecha'>" . $fe . "</td><td class='total'>" . $to . "</td></tr>";
            $total_general+=$to;
        }
        $html .= "<tr><td class='id'>Total general</td><td class='tipo_venta'></td><td class='fecha'></td><td class='total'>" . $total_general . "</td></tr>";
        $html .= "</table>";
        $html .= "</div>";
        //$html .= "<div style='background-image: url('../../assets/img/fondo.png')' height='350px' width='100%'>";
        // $pdf->Image($url.'assets/img/bienvenida.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Reporte.pdf");
        $pdf->Output($nombre_archivo, 'D');
    }
}
