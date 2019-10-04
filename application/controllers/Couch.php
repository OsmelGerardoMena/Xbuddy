<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Couch extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }

    function agregar() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'Contrasena', 'trim|required');
        $this->form_validation->set_rules('correo', 'correo', 'trim|required');
        $this->form_validation->set_rules('telefono', 'telefono', 'trim|required');
        $this->form_validation->set_rules('contrasena', 'contrasena', 'trim|required');
        $this->form_validation->set_rules('sexo', 'sexo', 'trim|required');

        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->form_validation->run() && $this->upload->do_upload('foto')) {

            $nom = $this->input->post('nombre');
            $ape = $this->input->post('apellidos');
            $cor = $this->input->post('correo');
            $tel = $this->input->post('telefono');
            $con = $this->input->post('contrasena');
            $sex = $this->input->post('sexo');

            $addI = array (
                'Usuario'        => iniciales(ucwords($nom . ' ' . $ape)),
                'Nombre'         => ucwords($nom),
                'Apellidos'      => ucwords($ape),
                'Foto'           => $this->upload->data('file_name'),
                'Correo'         => $cor,
                'Contrasena'     => $con,
                'Telefono'       => $tel,
                'Fecha_registro' => date('Y-m-d G:i:s'),
                'Sexo'           => $sex
            );

            $id = $this->AdminsMod->agregar('Informacion', $addI);

            $addT = array (
                'Estatus'     => 1,
                'Informacion' => $id
            );

            $idC = $this->AdminsMod->agregar('Couch', $addT);

            $this->AdminsMod->bitacora('Nuevo Couch', 'Couch', $idC);
        }

        redirect("View/ver_/Couch");

    }

    function editar() {

        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('apellidos', 'Contrasena', 'trim|required');
        $this->form_validation->set_rules('correo', 'correo', 'trim|required');
        $this->form_validation->set_rules('telefono', 'telefono', 'trim|required');
        $this->form_validation->set_rules('contrasena', 'contrasena', 'trim|required');
        $this->form_validation->set_rules('sexo', 'sexo', 'trim|required');

        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $nom = $this->input->post('nombre');
            $ape = $this->input->post('apellidos');
            $cor = $this->input->post('correo');
            $tel = $this->input->post('telefono');
            $con = $this->input->post('contrasena');
            $sex = $this->input->post('sexo');

            $config['upload_path'] = './assets/files/';
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['encrypt_name'] = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            $upI['Usuario'] = iniciales(ucwords($nom . ' ' . $ape));
            $upI['Nombre'] = ucwords($nom);
            $upI['Apellidos'] = ucwords($ape);
            $upI['Correo'] = $cor;
            $upI['Contrasena'] = $con;
            $upI['Telefono'] = $tel;
            $upI['Sexo'] = $sex;

            if ($this->upload->do_upload('foto')) {

                $upI['Foto'] = $this->upload->data('file_name');
            }

            $this->AdminsMod->editar('Informacion', 'idInformacion', $id, $upI);

            $this->AdminsMod->bitacora('Edicion Couch', 'Couch', $id);
        }

        redirect("View/ver_/Couch");

    }

    function eliminar() {

        $id = $this->input->post('id');

        $this->AdminsMod->editar('Couch', 'idCouch', $id, array ( 'Estatus' => 2 ));

        $this->AdminsMod->bitacora('Eliminar Couch', 'Couch', $id);

    }

    function get_info() {
        $all = $this->AdminsMod->get_info('Couch');

        foreach ($all as $row) {
            $data['data'][] = array (
                "id"        => $row->idCouch,
                "info"      => $row->Informacion,
                "usuario"   => $row->Usuario,
                "nombre"    => $row->Nombre,
                "apellidos" => $row->Apellidos,
                "foto"      => '<img src="' . archivos($row->Foto) . '" class="img-responsive img-circle" style="max-height: 75px; max-width: 75px">',
                "correo"    => $row->Correo,
                "btn_ed"    => '<a class="btn btn-default btn-block" href="' . site_url('View/nuevo_/Couch/' . $row->Informacion) . '"><span class="fa fa-edit"></span></a>',
                "btn_el"    => '<button type="button" class="btn btn-danger btn-block" onclick="eliminar(' . $row->idCouch . ')"><span class="fa fa-trash"></span></button>'
            );
        }

        echo json_encode($data);

    }

    function check_telefono() {
        $telf = $this->input->post('tel');
        $id = $this->input->post('id');
        $usu = $this->AdminsMod->seleccion('concat(Nombre," ",Apellidos) as Nombre', 'vwCouches', 'Telefono = "' . $telf . '" and Estatus = 1  and Informacion <> ' . $id);

        if ($usu != null) {
            echo $usu->Nombre;
        } else {
            echo 0;
        }

    }

}
