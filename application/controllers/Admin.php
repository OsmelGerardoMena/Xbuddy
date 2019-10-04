<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }

    public function login() {

        $this->form_validation->set_rules('user', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required');

        if ($this->form_validation->run()) {

            $n = $this->input->post('user');
            $p = $this->input->post('password');

            $log = $this->AdminsMod->login($n, $p);

            if ($log) {
                redirect('View/inicio');
            } else {
                $this->load->view('login');
            }
        }

    }

    public function login_QR() {

        $resp['success'] = 0;
        $resp['mensajes'] = 'error';

        $this->form_validation->set_rules('user', 'user', 'trim|required');
        $this->form_validation->set_rules('qr', 'qr', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');

        if ($this->form_validation->run()) {

            $id = $this->input->post('user');
            $qr = $this->input->post('qr');
            $tipo = $this->input->post('tipo');

            $log = $this->AdminsMod->login_qr($id, $qr, $tipo);

            if ($log != false) {
                $resp['success'] = 1;
                $resp['mensajes'] = $log;
            }
        }

        echo json_encode($resp);

    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('View/index');

    }

}
