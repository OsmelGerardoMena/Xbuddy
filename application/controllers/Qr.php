<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');
        $this->load->library('ci_qr_code');
        $this->config->load('qr_code');

    }

    function generar_qr($user_id) {
        $qr_code_config = array ();
        $qr_code_config['cacheable'] = $this->config->item('cacheable');
        $qr_code_config['cachedir'] = $this->config->item('cachedir');
        $qr_code_config['imagedir'] = $this->config->item('imagedir');
        $qr_code_config['errorlog'] = $this->config->item('errorlog');
        $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
        $qr_code_config['quality'] = $this->config->item('quality');
        $qr_code_config['size'] = $this->config->item('size');
        $qr_code_config['black'] = $this->config->item('black');
        $qr_code_config['white'] = $this->config->item('white');
        $this->ci_qr_code->initialize($qr_code_config);

        $user_details = $this->AdminsMod->seleccion('*', 'vwClientes', 'idCliente = ' . $user_id);
        $image_name = $user_id . ".png";

        $codeContents = "$user_id";
        $codeContents .= ",";
        $codeContents .= "$user_details->Qr";
        $codeContents .= ",";
        $codeContents .= "Cliente";

        $params['data'] = $codeContents;
        $params['level'] = 'H';
        $params['size'] = 2;

        $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
        $this->ci_qr_code->generate($params);

        $this->data['qr_code_image_url'] = base_url() . $qr_code_config['imagedir'] . $image_name;

        $this->AdminsMod->bitacora('Generar QR', 'Clientes', $user_id);

        echo $file = $params['savename'];
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

    }

}
