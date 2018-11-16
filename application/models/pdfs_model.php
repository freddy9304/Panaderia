<?php
class Pdfs_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	//obtenemos las provincias para cargar en el select
	function getVentasPdf()
	{
		$query = $this->db->get('ventas');
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $fila)
			{
				$data[] = $fila;
			}
				return $data;
		}
	}
    //obtenemos las localidades dependiendo de la provincia escogida
    function getVentasSeleccionadas($type_venta,$fec1,$fec2){
			// echo "modelo: ".$type_venta;die();
			if ($type_venta=='all') {
				$filters = $fec1 ? " and fecha_registro BETWEEN '{$fec1}' and '{$fec2}'":' ';
				$this->db->select("*")->from("ventas")->where("isDelete = 0 {$filters}");
			}elseif ($type_venta=='Pedidos_pasteles') {
				// $filters = $fec1 ? " and fecha_registro BETWEEN '{$fec1}' and '{$fec2}'":' ';
				$filter = $type_venta ? " and tipo_venta = 'Pedidos_pasteles'":'';
				$query = $this->db->select("*")->from("ventas_pasteles")->where("isDelete = 0 {$filter}");
			}else{
				$filters = $fec1 ? " and fecha_registro BETWEEN '{$fec1}' and '{$fec2}'":' ';
				$filter = $type_venta ? " and tipo_venta = '{$type_venta}'":'';
				$query = $this->db->select("*")->from("ventas")->where("isDelete = 0 {$filter} {$filters}");
			}
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
          return $query->result();
          }else{
          return null;
        }
	}
}
/*pdf_model.php
 * el modelo
 */
