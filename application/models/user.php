<?php

/**
 *
 */
class User extends CI_Model
{

  public function getUser($nick = '',$password = '')
  {
      $result = $this->db->query("SELECT * from user where nick = '".$nick."' and password = '".$password."' LIMIT 1");
      // print_r($result);
      if ($result->num_rows() > 0) {
        return $result->row();
      }else{
        return null;
      }
  }
}
