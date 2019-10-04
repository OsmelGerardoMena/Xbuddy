<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clases extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');
        $this->load->model('ClaseMod');

    }

    function agregar() {

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('categoria', 'categoria', 'trim|required');
        $this->form_validation->set_rules('couch', 'couch', 'trim|required');
        $this->form_validation->set_rules('miembros', 'miembros', 'trim|required');
        $this->form_validation->set_rules('h_inicio', 'h_inicio', 'trim|required');
        $this->form_validation->set_rules('h_fin', 'h_fin', 'trim|required');
        $this->form_validation->set_rules('f_inicio', 'f_inicio', 'trim|required');

        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->form_validation->run() && $this->upload->do_upload('foto')) {

            $nom = $this->input->post('nombre');
            $cat = $this->input->post('categoria');
            $cou = $this->input->post('couch');
            $mie = $this->input->post('miembros');
            $h_i = $this->input->post('h_inicio');
            $h_f = $this->input->post('h_fin');
            $f_i = $this->input->post('f_inicio');
            $f_f = ($this->input->post('f_fin')) ? $this->input->post('f_fin') : null;
            $dia = json_encode($this->input->post('dias'));

            $addT = array (
                'Clase'          => $nom,
                'Imagen'         => $this->upload->data('file_name'),
                'Miembros'       => $mie,
                'H_inicio'       => $h_i,
                'H_fin'          => $h_f,
                'F_inicio'       => $f_i,
                'F_fin'          => $f_f,
                'Dias'           => $dia,
                'Categoria'      => $cat,
                'Couch'          => $cou,
                'Estatus'        => 1,
                'Fecha_registro' => date('Y-m-d G:i:s')
            );

            $idC = $this->AdminsMod->agregar('Clases', $addT);

            $this->AdminsMod->bitacora('Nueva Clase', 'Clases', $idC);
        }

        redirect("View/lst_clase");

    }

    function editar() {

        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('categoria', 'categoria', 'trim|required');
        $this->form_validation->set_rules('couch', 'couch', 'trim|required');
        $this->form_validation->set_rules('miembros', 'miembros', 'trim|required');
        $this->form_validation->set_rules('h_inicio', 'h_inicio', 'trim|required');
        $this->form_validation->set_rules('h_fin', 'h_fin', 'trim|required');
        $this->form_validation->set_rules('f_inicio', 'f_inicio', 'trim|required');

        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $nom = $this->input->post('nombre');
            $cat = $this->input->post('categoria');
            $cou = $this->input->post('couch');
            $mie = $this->input->post('miembros');
            $h_i = $this->input->post('h_inicio');
            $h_f = $this->input->post('h_fin');
            $f_i = $this->input->post('f_inicio');
            $f_f = ($this->input->post('f_fin')) ? $this->input->post('f_fin') : null;
            $dia = json_encode($this->input->post('dias'));

            $config['upload_path'] = './assets/files/';
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['encrypt_name'] = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            $upI['Clase'] = $nom;
            $upI['Miembros'] = $mie;
            $upI['H_inicio'] = $h_i;
            $upI['H_fin'] = $h_f;
            $upI['F_inicio'] = $f_i;
            $upI['F_fin'] = $f_f;
            $upI['Dias'] = $dia;
            $upI['Categoria'] = $cat;
            $upI['Couch'] = $cou;

            if ($this->upload->do_upload('foto')) {

                $upI['Imagen'] = $this->upload->data('file_name');
            }

            $this->AdminsMod->editar('Clases', 'idClase', $id, $upI);

            $this->AdminsMod->bitacora('Edicion Clase', 'Clases', $id);
        }

        redirect("View/lst_clase");

    }

    function eliminar() {

        $id = $this->input->post('id');

        $this->AdminsMod->editar('Clases', 'idClase', $id, array ( 'Estatus' => 2 ));

        $this->AdminsMod->bitacora('Eliminar Clase', 'Clases', $id);

    }

    function get_info() {
        $all = $this->AdminsMod->seleccion('*', 'vwClases', 'Estatus = 1', true);
        $no = $this->ClaseMod->get_no_miembros();

        foreach ($all as $row) {
            $nom = 0;
            foreach ($no as $n) {
                if ($n->Clase == $row->idClase) {
                    $nom = $n->No;
                }
            }

            $data['data'][] = array (
                "id"        => $row->idClase,
                "miembros"  => '<button type="button" class="btn btn-default btn-block" onclick="miembros(' . $row->idClase . ')"><span class="fa fa-users"></span></button>',
                "clase"     => $row->Clase . ' (' . $nom . ')',
                "imagen"    => '<img src="' . archivos($row->Imagen) . '" class="img-responsive img-circle" style="max-height: 75px; max-width: 75px">',
                "f_inicio"  => $row->F_inicio,
                "categoria" => $row->Categoria_nombre,
                "couch"     => $row->Couch_nombre,
                "btn_ed"    => '<a class="btn btn-default btn-block" href="' . site_url('View/clase_agregar/' . $row->idClase) . '"><span class="fa fa-edit"></span></a>',
                "btn_el"    => '<button type="button" class="btn btn-danger btn-block" onclick="eliminar(' . $row->idClase . ')"><span class="fa fa-trash"></span></button>'
            );
        }

        echo json_encode($data);

    }

    function check_nombre() {
        $nom = $this->input->post('nombre');
        $id = $this->input->post('id');
        $usu = $this->AdminsMod->seleccion('Clase', 'vwClases', 'Clase = "' . $nom . '" and Estatus = 1  and idClase <> ' . $id);

        if ($usu != null) {
            echo $usu->Nombre;
        } else {
            echo 0;
        }

    }

    function miembros_clase() {
        $clase = $this->input->post('clase');
        $miembros = $this->AdminsMod->seleccion('*', 'vwMiembros_Clase', 'Clase = ' . $clase, true);
        echo json_encode($miembros);

    }

}
