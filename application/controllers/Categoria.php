<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }

    function agregar() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');

        if ($this->form_validation->run()) {

            $nom = $this->input->post('nombre');
            $des = $this->input->post('descripcion');

            $addT = array (
                'Nombre'         => $nom,
                'Descripcion'    => $des,
                'Estatus'        => 1,
                'Fecha_registro' => date('Y-m-d G:i:s')
            );

            $idC = $this->AdminsMod->agregar('Categorias', $addT);

            $this->AdminsMod->bitacora('Nueva Categoria', 'Categorias', $idC);
        }

        redirect("View/lst_categoria");

    }

    function editar() {

        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');

        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $nom = $this->input->post('nombre');
            $des = $this->input->post('descripcion');

            $addUp = array (
                'Nombre'      => $nom,
                'Descripcion' => $des
            );

            $this->AdminsMod->editar('Categorias', 'idCategoria', $id, $addUp);

            $this->AdminsMod->bitacora('Edicion Categoria', 'Categorias', $id);
        }

        redirect("View/lst_categoria");

    }

    function eliminar() {

        $id = $this->input->post('id');

        $this->AdminsMod->editar('Categorias', 'idCategoria', $id, array ( 'Estatus' => 2 ));

        $this->AdminsMod->bitacora('Eliminar Categoria', 'Categorias', $id);

    }

    function get_info() {
        $all = $this->AdminsMod->seleccion('*', 'Categorias', 'Estatus = 1', true);

        foreach ($all as $row) {
            $data['data'][] = array (
                "id"          => $row->idCategoria,
                "nombre"      => $row->Nombre,
                "descripcion" => $row->Descripcion,
                "fecha"       => $row->Fecha_registro,
                "btn_ed"      => '<a class="btn btn-default btn-block" href="' . site_url('View/categoria_agregar/' . $row->idCategoria) . '"><span class="fa fa-edit"></span></a>'
                    //"btn_el"    => '<button type="button" class="btn btn-danger btn-block" onclick="eliminar(' . $row->idCliente . ')"><span class="fa fa-trash"></span></button>'
            );
        }

        echo json_encode($data);

    }

    function check_nombre() {
        $nom = $this->input->post('nombre');
        $id = $this->input->post('id');
        $usu = $this->AdminsMod->seleccion('Nombre', 'Categorias', 'Nombre = "' . $nom . '" and Estatus = 1  and idCategoria <> ' . $id);

        if ($usu != null) {
            echo $usu->Nombre;
        } else {
            echo 0;
        }

    }

}
