<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Membrecia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }

    function agregar() {

        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('tarifa', 'tarifa', 'trim|required');

        if ($this->form_validation->run()) {

            $cliente = $this->input->post('id');
            $tarifa = $this->input->post('tarifa');

            $tipo = $this->AdminsMod->seleccion('Tipo', 'Tarifas', 'idTarifa = ' . $tarifa);

            if ($tipo->Tipo != 'visita') {
                switch ($tipo->Tipo) {
                    case 'semana':
                        $vencimientos = date("Y-m-d", strtotime("+1 week"));
                        break;
                    case 'mes':
                        $vencimientos = date("Y-m-d", strtotime("+1 month"));
                        break;
                    case 'ano':
                        $vencimientos = date("Y-m-d", strtotime("+1 year"));
                        break;
                }
            } else {
                $vencimientos = null;
            }

            $addT = array (
                'Tarifa'            => $tarifa,
                'Cliente'           => $cliente,
                'Estatus'           => 3,
                'Recepcion'         => $this->session->userdata('log'),
                'Nvl'               => $this->session->userdata('nvl'),
                'Fecha_registro'    => date('Y-m-d G:i:s'),
                'Fecha_vencimiento' => $vencimientos
            );

            $idC = $this->AdminsMod->agregar('Membrecias', $addT);

            $this->AdminsMod->bitacora('Nueva Membrecia', 'Membrecias', $idC);
        }

        redirect("View/membrecias_ver");

    }

    function get_info() {
        $all = $this->AdminsMod->seleccion('*', 'vwMembrecias', '', true);

        foreach ($all as $row) {
            $data['data'][] = array (
                "id"          => $row->idMembrecia,
                "registro"    => $row->Fecha_registro,
                "vencimiento" => ($row->Fecha_vencimiento == null) ? '' : $row->Fecha_vencimiento,
                "estatus"     => ($row->Estatus == 3) ? '<p class="text-success">' . $row->Estatus_Nombre . '</p>' : '<p class="text-danger">' . $row->Estatus_Nombre . '</p>',
                "tipo"        => $row->Nombre . ' ($' . $row->Cuota . ')',
                "cliente"     => $row->Nombre_Cliente,
                "btn_ver"     => '<button type="button" class="btn btn-default btn-block" onclick="detalles(' . $row->idMembrecia . ')"><span class="fa fa-eye"></span></button>',
                "btn_eli"     => ($row->Estatus == 3) ? '<button type="button" class="btn btn-warning btn-block" onclick="cancelar(' . $row->idMembrecia . ')"><span class="fa fa-trash"></span></button>' : ''
            );
        }

        echo json_encode($data);

    }

    function detalles() {
        $id = $this->input->post('id');
        $row = $this->AdminsMod->seleccion('*', 'vwMembrecias', 'idMembrecia = ' . $id);
        echo json_encode($row);

    }

    function cancelar() {
        $id = $this->input->post('id');
        $up = array (
            'Estatus' => 4
        );
        $this->AdminsMod->editar('Membrecias', 'idMembrecia', $id, $up);

    }

}
