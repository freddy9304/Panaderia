<?php

/**
 *
 */
class Excel_export_model extends CI_Model
{

  public function fetch_data()
  {
      $this->db->order_by("id","ASCE");
      $query = $this->db->get("ventas");
      return $query->result();
  }
}
