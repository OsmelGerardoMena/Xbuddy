<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminsMod extends CI_Model {

    public function __construct() {
        date_default_timezone_set('America/Mexico_City');
        parent::__construct();

    }

    public function datos_inicio() {
        $row['crecimiento'] = $this->db->query('select count(*) as Num, month(Fecha_registro) as Mes from vwClientes group by month(Fecha_registro) order by month(Fecha_registro) desc;')->result();
        $row['usuarios'] = $this->db->query('select Fecha_registro,idCliente, concat(Nombre," ",Apellidos) as Nombre, foto from vwClientes where Estatus = 1 order by idCliente desc limit 10;')->result();
        $row['total_usuarios'] = $this->db->query('select count(*) as total from vwClientes where Estatus = 1 order by idCliente desc;')->row();
        return $row;

    }

    public function get_info($tb) {
        $result = $this->db->query('select * from ' . $tb . ' t inner join Informacion i on t.Informacion = i.idInformacion and t.Estatus = 1;');
        return $result->result();

    }
    
    public function select($tb) {
        
        $result = $this->db->query($tb);
        return $result->result();

    }

    public function seleccion($select, $tabla, $where = '', $all = FALSE, $order_col = '', $order = '') {
        $this->db->select($select);
        $this->db->from($tabla);

        if ($where != '') {
            $this->db->where($where);
        }

        if ($order != '' && $order_col != '') {
            $this->db->order_by($order_col, $order);
        }

        $sql = $this->db->get();
        if ($all) {
            return $sql->result();
        } else {
            $sess = $sql->row();
            return $sess;
        }

    }

    public function agregar($tabla, array $datos) {
        $this->db->insert($tabla, $datos);
        return $this->db->insert_id();

    }

    public function editar($tabla, $colID, $id, array $datos) {
        $this->db->where($colID, $id);
        $this->db->update($tabla, $datos);

    }

    function bitacora($des, $mod = '', $id_mod = 0) {
        $this->db->query("CALL spBitacora('$des','$mod',$id_mod," . $this->session->userdata('nvl') . "," . $this->session->userdata('log') . ",1);");

    }

    public function login($user, $pass) {

        $row = $this->db->query('SELECT * FROM Admin WHERE Usuario = "' . $user . '";')->row();
        if ($row != null && $row->Contrasena == $pass) {
            $user_array = array (
                'user'   => $row->Usuario,
                'log'    => $row->idAdmin,
                'sesion' => true,
                'img'    => $row->Foto,
                'nvl'    => 1
            );

            $this->session->set_userdata($user_array);

            $this->bitacora('Inicio Sesion');

            return true;
        } else {
            $row = $this->db->query("select * from Recepcion t inner join Informacion i on t.Informacion = i.idInformacion and i.Usuario = '" . $user . "';")->row();

            if ($row != null && $row->Contrasena == $pass) {
                $user_array = array (
                    'user'   => $row->Usuario,
                    'log'    => $row->idRecepcion,
                    'sesion' => true,
                    'img'    => $row->Foto,
                    'nvl'    => 2
                );

                $this->session->set_userdata($user_array);

                $this->bitacora('Inicio Sesion');

                return true;
            }
        }

        return false;

    }

    function login_qr($id, $qr, $tipo) {
        $row = $this->db->query('CALL spLoginQR("' . $id . '","' . $qr . '","' . $tipo . '");')->row();
        if ($row) {
            return $row;
        } else {
            return false;
        }

    }

}
