<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AdminsMod');
        $this->load->model('MembreciaMod');
        $this->load->model('ClaseMod');

    }

    function index() {
        if (!$this->session->userdata('sesion')) {
            $this->load->view('login');
        } else {
            redirect('View/inicio');
        }

    }

    function Qr_check() {
        $this->load->view('login_1');

    }

    function inicio() {
        if ($this->session->userdata('sesion')) {
            $data['title'] = 'Bienvenido ' . $this->session->userdata('user');
            $data['datos'] = $this->AdminsMod->datos_inicio();
            $data['content'] = 'inicio_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function nuevo_($tb, $info = null) {
        if ($this->session->userdata('sesion')) {
            if ($info != null) {
                $data['title'] = 'Editar ' . $tb;
                $data['datos'] = $this->AdminsMod->seleccion('*', 'Informacion', 'idInformacion = ' . $info);
            } else {
                $data['title'] = 'Registrar Nuevo ' . $tb;
            }

            $data['tipo'] = $tb;
            $data['content'] = 'nuevo_info_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function ver_() {
        if ($this->session->userdata('sesion')) {
            $tipo = $this->uri->segment(3);
            $data['title'] = 'Lista - ' . $tipo;
            $data['tipo'] = $tipo;
            $data['content'] = 'ver_info_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function membrecias_ver() {
        if ($this->session->userdata('sesion')) {
            $data['title'] = 'Lista - Membrecías';
            $data['content'] = 'lst_membrecias';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function membrecias_agregar() {

        if ($this->session->userdata('sesion')) {
            $data['clientes'] = $this->MembreciaMod->get_disponibles();
            $data['tarifas'] = $this->AdminsMod->seleccion('*', 'Tarifas', 'Estatus = 1', true);
            $data['title'] = 'Agregar Membrecía';
            $data['content'] = 'membrecia_nueva_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function tarifas_ver() {
        if ($this->session->userdata('sesion')) {
            $data['title'] = 'Lista - Tarifas';
            $data['content'] = 'lst_tarifas';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function tarifas_agregar() {
        if ($this->session->userdata('sesion')) {
            if ($this->uri->segment(3)) {
                $data['title'] = 'Editar Tarifa';
                $data['datos'] = $this->AdminsMod->seleccion('*', 'Tarifas', 'idTarifa = ' . $this->uri->segment(3));
            } else {
                $data['title'] = 'Registrar Nueva Tarifa';
            }
            $data['content'] = 'tarifa_nueva_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function categoria_agregar() {
        if ($this->session->userdata('sesion')) {
            if ($this->uri->segment(3)) {
                $data['title'] = 'Editar Categoria';
                $data['datos'] = $this->AdminsMod->seleccion('*', 'Categorias', 'idCategoria = ' . $this->uri->segment(3));
            } else {
                $data['title'] = 'Registrar Nueva Categoria';
            }
            $data['content'] = 'categoria_nueva_view';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function lst_categoria() {
        if ($this->session->userdata('sesion')) {
            $data['title'] = 'Lista - Categorias';
            $data['content'] = 'lst_categoria';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function clase_agregar() {
        if ($this->session->userdata('sesion')) {
            if ($this->uri->segment(3)) {
                $data['title'] = 'Editar Clase';
                $data['datos'] = $this->AdminsMod->seleccion('*', 'vwClases', 'idClase = ' . $this->uri->segment(3));
            } else {
                $data['title'] = 'Registrar Nueva Clase';
            }
            $data['content'] = 'clases_nueva_view';
            $data['couch'] = $this->AdminsMod->seleccion('*', 'vwCouches', 'Estatus = 1', true);
            $data['categoria'] = $this->AdminsMod->seleccion('*', 'Categorias', 'Estatus = 1', true);
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

    function lst_clase() {
        if ($this->session->userdata('sesion')) {
            $data['title'] = 'Lista - Clases';
            $data['content'] = 'lst_clases';
            $this->load->view('base', $data);
        } else {
            redirect("View");
        }

    }

}
