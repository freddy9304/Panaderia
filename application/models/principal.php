<?php

/**
 *
 */
class Principal extends CI_Model
{

    public function principalModel(){
        $this->db->select('tp.idtipo_pan,p.idpan, tp.name_pan, pr.precio')->from('panes p')->join('tipo_pan tp', 'p.idtipo=tp.idtipo')->join('precio pr', 'p.idprecio=pr.idprecio')->where('tp.idtipo_pan=1');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelDulce(){
        $this->db->select('tp.idtipo_pan,p.idpan, tp.name_pan, pr.precio')->from('panes p')->join('tipo_pan tp', 'p.idtipo=tp.idtipo')->join('precio pr', 'p.idprecio=pr.idprecio')->where('tp.idtipo_pan=2');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelResposteria(){
        $this->db->select('tp.idtipo_pan,p.idpan, tp.name_pan, pr.precio')->from('panes p')->join('tipo_pan tp', 'p.idtipo=tp.idtipo')->join('precio pr', 'p.idprecio=pr.idprecio')->where('tp.idtipo_pan=3');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelVelas(){
        $this->db->select('e.idextra, te.name_extra, pr.precio,te.idtipo_extra')->from('extra e')->join('tipo_extra te', 'e.idextra=te.idtipo')->join('precio pr', 'e.idprecio=pr.idprecio')->where('te.idtipo_extra=1');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelLeche(){
        $this->db->select('e.idextra, te.name_extra, pr.precio,te.idtipo_extra')->from('extra e')->join('tipo_extra te', 'e.idextra=te.idtipo')->join('precio pr', 'e.idprecio=pr.idprecio')->where('te.idtipo_extra=2');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelCafe(){
        $this->db->select('e.idextra, te.name_extra, pr.precio,te.idtipo_extra')->from('extra e')->join('tipo_extra te', 'e.idextra=te.idtipo')->join('precio pr', 'e.idprecio=pr.idprecio')->where('te.idtipo_extra=3');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelChoco(){
        $this->db->select('e.idextra, te.name_extra, pr.precio,te.idtipo_extra')->from('extra e')->join('tipo_extra te', 'e.idextra=te.idtipo')->join('precio pr', 'e.idprecio=pr.idprecio')->where('te.idtipo_extra=4');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
    public function principalModelRebanadas(){
        $this->db->select('r.idreposteria, tr.name_reposteria, pr.precio,tr.idtipo_reposteria')->from('reposteria r')->join('tipo_reposteria tr', 'r.idreposteria=tr.idtipo')->join('precio pr', 'r.idprecio=pr.idprecio')->where('tr.idtipo_reposteria=1');
        $query = $this->db->get();
          if ($query->num_rows() > 0) {
            return $query->result();
            }else{
            return null;
          }
    }
}
