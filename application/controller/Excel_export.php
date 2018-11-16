<?php

/**
 *
 */
class Excel_export extends CI_Controller
{

  function index()
  {
    $this->load->model("Excel_export_model");
    $data['ventas_all'] = $this->Excel_export_model->fetch_data();
    $this->load->view("index.phtml",$data);
  }

  public function action($general='',$fe1='',$fe2='')
  {
    // echo "variable general:".$general;die();
    $this->load->model("Excel_export_model");
    $this->load->library("Excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);
    if ($general=='Pedidos_pasteles') {
      $table_columns = array("Id","Tipo_venta","Nombre del Cliente","Dirección","Telefono","Celular","Correo","Especificaciones","Relleno","Cantidad","Base","Anticipo","Total");
    }else{
      $table_columns = array("Id","Tipo_venta","Fecha de registro","Estatus","Tipo de pago","Folio","Total");
    }

    $column = 0;

    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }
    $type_venta = $general;
    $fec1 = $fe1;
    $fec2 = $fe2;
    // print_r($fec1.' '.$fec2);die();
    $ventas_data = $this->Excel_export_model->fetch_data($type_venta,$fec1,$fec2);

    $excel_row = 2;
    $total_general = 0;
    // echo "<pre>";
    // print_r($ventas_data);
    // echo "<pre>";die();
    if ($type_venta=='Pedidos_pasteles') {
      foreach ($ventas_data as $row) {
        // print_r($row);die();
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->idventas_pasteles);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tipo_venta);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->nombre);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->direccion);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->telefono);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->celular);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->correo!=''?$row->correo:'Sin Correo');
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->especificaciones!=''?$row->especificaciones:'Sin Especificaciones');
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->relleno);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->cantidad);
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->base!=0?$row->base:'0');
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->anticipo!=0?$row->anticipo:'0');
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->total);
        // $object->getActiveSheet()->setCellValueByColumnAndRow(4, $total, 'total de los precios iria aqui');
        $excel_row++;
        $total_general+=$row->total;
      }
      $object->getActiveSheet()->SetCellValue('A'.$excel_row,'Total General');
      $object->getActiveSheet()->SetCellValue('M'.$excel_row, $total_general);
    }else{
      foreach ($ventas_data as $row) {
        // print_r($row);die();
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tipo_venta);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->fecha_registro);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->confirm==1?'Liquidado':'Pendiente');
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->tipo_pago==0?'No pagado':($row->tipo_pago==1?'Efectivo':'Tarjeta'));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->folio);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->total);
        // $object->getActiveSheet()->setCellValueByColumnAndRow(4, $total, 'total de los precios iria aqui');
        $excel_row++;
        $total_general+=$row->total;
      }
      $object->getActiveSheet()->SetCellValue('A'.$excel_row,'Total General');
      $object->getActiveSheet()->SetCellValue('G'.$excel_row, $total_general);
    }
    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Ventas_totales.xls"');
    $object_writer->save('php://output');
  }
}
