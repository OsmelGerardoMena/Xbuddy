<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }

    function agregar() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('cuota', 'cuota', 'trim|required');

        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->form_validation->run() && $this->upload->do_upload('foto')) {

            $nom = $this->input->post('nombre');
            $tip = $this->input->post('tipo');
            $cuo = $this->input->post('cuota');
            $des = $this->input->post('descripcion');

            $addT = array (
                'Nombre'         => $nom,
                'Tipo'           => $tip,
                'Cuota'          => $cuo,
                'Foto'           => $this->upload->data('file_name'),
                'Descripcion'              => $des,
                'Fecha_registro' => date('Y-m-d G:i:s')
            );

            $idC = $this->AdminsMod->agregar('Tarifas', $addT);

            $this->AdminsMod->bitacora('Nueva Tarifa', 'Tarifas', $idC);
        }

        redirect("View/tarifas_ver");

    }

    function editar() {

        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('cuota', 'cuota', 'trim|required');

        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $nom = $this->input->post('nombre');
            $tip = $this->input->post('tipo');
            $cuo = $this->input->post('cuota');
            $des = $this->input->post('descripcion');


            $config['upload_path'] = './assets/files/';
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['encrypt_name'] = true;

            $this->load->library('upload');
            $this->upload->initialize($config);
            if($this->upload->do_upload('foto')){
                $addUp = array (
                    'Nombre' => $nom,
                    'Tipo'   => $tip,
                    'Cuota'  => $cuo,
                    'Foto'           => $this->upload->data('file_name'),
                    'Descripcion'              => $des
                );
            }
            else
            {
                $addUp = array (
                    'Nombre' => $nom,
                    'Tipo'   => $tip,
                    'Cuota'  => $cuo,
                    'Descripcion'              => $des
                );

            }




            $this->AdminsMod->editar('Tarifas', 'idTarifa', $id, $addUp);

            $this->AdminsMod->bitacora('Edicion Tarifa', 'Tarifas', $id);
        }

        redirect("View/tarifas_ver");

    }

    function eliminar() {

        $id = $this->input->post('id');

        $this->AdminsMod->editar('Tarifas', 'idTarifa', $id, array ( 'Estatus' => 2 ));

        $this->AdminsMod->bitacora('Eliminar Tarifa', 'Tarifas', $id);

    }

    function get_info() {
        $all = $this->AdminsMod->seleccion('*', 'Tarifas', 'Estatus = 1', true);

        foreach ($all as $row) {
            $data['data'][] = array (
                "id"     => $row->idTarifa,
                "nombre" => $row->Nombre,
                "tipo"   => ($row->Tipo == 'ano') ? 'Año' : ucfirst($row->Tipo),
                "cuota"  => '$' . $row->Cuota,
                "fecha"  => $row->Fecha_registro,
                "btn_ed" => '<a class="btn btn-default btn-block" href="' . site_url('View/tarifas_agregar/' . $row->idTarifa) . '"><span class="fa fa-edit"></span></a>'
                //"btn_el"    => '<button type="button" class="btn btn-danger btn-block" onclick="eliminar(' . $row->idCliente . ')"><span class="fa fa-trash"></span></button>'
            );
        }

        echo json_encode($data);

    }

    function check_nombre() {
        $nom = $this->input->post('nombre');
        $id = $this->input->post('id');
        $usu = $this->AdminsMod->seleccion('Nombre', 'Tarifas', 'Nombre = "' . $nom . '" and Estatus = 1  and idTarifa <> ' . $id);

        if ($usu != null) {
            echo $usu->Nombre;
        } else {
            echo 0;
        }

    }

}
