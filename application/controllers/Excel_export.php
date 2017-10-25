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

  public function action()
  {
    $this->load->model("Excel_export_model");
    $this->load->library("Excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);

    $table_columns = array("Id","Tipo_venta","Fecha_venta","Total");

    $column = 0;

    foreach ($table_columns as $field) {
      $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
      $column++;
    }

    $ventas_data = $this->Excel_export_model->fetch_data();

    $excel_row = 2;
    $total_general = 0;

    foreach ($ventas_data as $row) {
      // print_r($row);die();
      $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tipo_venta);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->fecha_registro);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->total);
      // $object->getActiveSheet()->setCellValueByColumnAndRow(4, $total, 'total de los precios iria aqui');
      $excel_row++;
      $total_general+=$row->total;
    }
    $object->getActiveSheet()->SetCellValue('A'.$excel_row,'total a mostrar');
    $object->getActiveSheet()->SetCellValue('D'.$excel_row, $total_general);

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Ventas_totales.xls"');
    $object_writer->save('php://output');
  }
}
