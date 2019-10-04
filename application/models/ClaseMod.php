<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ClaseMod extends CI_Model {

    public function __construct() {
        date_default_timezone_set('America/Mexico_City');
        parent::__construct();

    }

    public function get_no_miembros() {
        $result = $this->db->query('select count(idCliente) as No, Clase from vwMiembros_Clase group by Clase;');
        return $result->result();

    }

}
