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
    function getVentasSeleccionadas()
	{
        $query = $this->db->select('*')->from('ventas')->where('isDelete = 0');
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
