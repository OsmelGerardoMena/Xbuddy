<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MembreciaMod extends CI_Model {

    public function __construct() {
        date_default_timezone_set('America/Mexico_City');
        parent::__construct();

    }

    public function get_disponibles() {
        $result = $this->db->query('select idCliente,Usuario,Nombre,Apellidos,Foto,Correo,Telefono from vwClientes where idCliente not in( select Cliente from Membrecias where Estatus = 3 and (Fecha_vencimiento >= now() or Fecha_vencimiento is null) );');
        return $result->result();

    }

}
