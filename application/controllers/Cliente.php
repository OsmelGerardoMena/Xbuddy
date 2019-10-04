<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('AdminsMod');

    }



    function write_log($cadena,$tipo)
    {
        $arch = fopen(realpath( '.' )."/logs/milog.txt", "a+"); 

        fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." - $tipo ] ".$cadena."\n");
        fclose($arch);
    }

    function  AddCliente(){

        //$this->form_validation->set_rules('user', 'user', 'trim|required');
        //$this->form_validation->set_rules('apellidos', 'Contrasena', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        //$this->form_validation->set_rules('sexo', 'sexo', 'trim|required');


        if ($this->form_validation->run()) {


            //$usu = $this->input->post('user');
            $nom = $this->input->post('name');
            $ape = $this->input->post('last_name');
            $cor = $this->input->post('email');
            $tel = $this->input->post('phone');
            $con = $this->input->post('password');

            $c = $this->AdminsMod->seleccion('*', 'Informacion', 'Correo="'.$cor.'" ');

            //$cc = $this->AdminsMod->seleccion('*', 'Informacion', 'Usuario="'.$usu.'" ');

            $ccc = $this->AdminsMod->seleccion('*', 'Informacion', 'Telefono="'.$this->input->post('phone').'" ');


            if(count($c)>0  || count($ccc)>0){

                $data = array (
                    "status"        => false,
                    "msg"   =>"Cliente ya existe"
                );

            }
            else
            {

                $cod=codigo();
                $addI = array (
                    'Contrasena'     => $con,
                    'Correo'         => $cor,
                    'Nombre'         => $nom,
                    'Apellidos'         => $ape,
                    'Telefono'       => $tel,
                    'Fecha_registro' => date('Y-m-d G:i:s'),
                    'Qr'             => $cod . ''
                );

                $id = $this->AdminsMod->agregar('Informacion', $addI);

                $addT = array (
                    'Estatus'     => 1,
                    'Informacion' => $id
                );

                $idC = $this->AdminsMod->agregar('Clientes', $addT);

                //$this->AdminsMod->bitacora('Nuevo Cliente', 'Clientes', $idC);


                $usus = $this->AdminsMod->seleccion('*', 'Informacion', 'idInformacion='.$id.' ');


                $qr = "$id";
                $qr .= ",";
                $qr .= "$cod";
                $qr .= ",";
                $qr .= "Cliente";


                $datoss = array (
                    'Nombre' => $usus->Nombre,
                    'Apellido' => $usus->Apellidos,
                    'Sexo'     => $usus->Sexo,
                    'Estatura'         => $usus->Estatura,
                    'Peso'       => $usus->Peso,
                    'Fecha_nacimiento' => $usus->Fecha_nacimiento,
                    'Nivel'         => $usus->Nivel,
                    'Correo'         => $cor,
                    'Telefono'       => $tel,
                    'Qr'             => $qr
                );

                $tok=token();
                $data = array (
                    "status"        => true,
                    //"msg"   =>"Cliente agregado con exito",
                    "token" =>$tok,
                    "user" =>$datoss
                );



                $addd = array (
                    'token'     => $tok,
                    'idCliente' => $usus->idInformacion
                );

                $this->AdminsMod->agregar('Session', $addd);

            }

        }
        else
        {
            $data = array (
                "status"        => false,
                //"msg"   =>"Cliente no agregado"
            );
        }

        echo json_encode($data);

    }

    function  Recovery(){


        $this->form_validation->set_rules('email', 'email', 'trim|required');


        if ($this->form_validation->run()) {


            $cor = $this->input->post('email');


            $c = $this->AdminsMod->seleccion('*', 'Informacion', 'Correo="'.$cor.'" ');


            if(count($c)==0){

                $data = array (
                    "status"        => false,
                    "msg"   =>"Email no existe"
                );

            }
            else
            {



                $emisor=$cor;
                $destinatario=$cor;//'info@agenciamarketing.com.uy';//'info@vca.com.uy';//$_POST['destinatario'];	

                //Estoy recibiendo el formulario, compongo el cuerpo
                $cuerpo = "<h1>Recuperar Clave</h1>";

                $cuerpo .= "<p> Gym, te envia este mensaje.</p>";
                $cuerpo .= "<p>Su password: " . $c->Contrasena . "</p>";


                //mando el correo...
                if(mail($destinatario,"Un mensaje de Gym",$cuerpo,"MIME-Version: 1.0\nContent-type: text/html; charset=UTF-8\nFrom: ".$emisor." ")){
                    $data = array (
                        "status"        => true,
                        "msg"   =>"Password enviado a su email"
                    );
                }
                else
                {
                    $data = array (
                        "status"        => true,
                        "msg"   =>"Error al enviar password a su email"
                    );
                }




            }

        }
        else
        {
            $data = array (
                "status"        => false,
                //"msg"   =>"Cliente no agregado"
            );
        }

        echo json_encode($data);

    }


    function Login(){

        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');

        if ($this->form_validation->run()) {

            $usu = $this->input->post('email');
            $con = $this->input->post('password');


            $addI = array (
                'Correo'        => $usu,
                'Contrasena'     => $con
            );



            $log=$this->AdminsMod->seleccion('*', 'Informacion', 'Correo="'.$usu.'" and Contrasena="'.$con.'" ');
            if(count($log)>0){
                $loga=$this->AdminsMod->seleccion('*', 'Clientes', 'Informacion="'.$log->idInformacion.'" ');


                $qr = "$log->idInformacion";
                $qr .= ",";
                $qr .= "$log->Qr";
                $qr .= ",";
                $qr .= "Cliente";

                $datoss = array (
                    'Nombre' => $log->Nombre,
                    'Apellido' => $log->Apellidos,
                    'Sexo'     => $log->Sexo,
                    'Estatura'         => $log->Estatura,
                    'Peso'       => $log->Peso,
                    'Fecha_nacimiento' => $log->Fecha_nacimiento,
                    'Nivel'         => $log->Nivel,
                    'Correo'         => $log->Correo,
                    'Telefono'       => $log->Telefono,
                    'Qr'             => $qr
                );


                $mes=mes(date('m'));

                $total=$this->AdminsMod->select("SELECT b.`Clase`,c.`Apellidos` AS ApellidosCouch,c.`Nombre` AS NombreCouch,CONCAT(SUM(DATE_FORMAT(TIMEDIFF(b.H_fin, b.H_inicio ),'%h')))AS duracion
FROM Estadisticas AS a
INNER JOIN Clases AS b ON a.`idClase`=b.`idClase`
INNER JOIN Informacion AS c ON c.idInformacion=(SELECT couch.Informacion FROM Couch AS couch WHERE b.Couch=couch.idCouch)
WHERE YEAR(a.Fecha)=".date('Y')." AND  MONTH(a.Fecha)=".date('m')." 
GROUP BY YEAR(a.Fecha),MONTH(a.Fecha),b.`idClase` ");

                $tok=token();
                $data = array (
                    "status"        => true,
                    //"msg"   =>"Session iniciada con exito",
                    "token" =>$tok,
                    "user" =>$datoss
                );

                $addd = array (
                    'token'     => $tok,
                    'idCliente' => $log->idInformacion
                );

                $this->AdminsMod->agregar('Session', $addd);

            }
            else
            {

                $data = array (
                    "status"        => false,
                    "msg"   =>"Usuario o contraseÃ±a incorrecto"
                );

            }




        }
        else
        {
            $data = array (
                "status"        => false,
                "msg"   =>"Error en inicio de session"
            );
        }

        echo json_encode($data);

    }

    function Estadisticas(){
        if($this->input->get('token')!=''){


            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" ');
            $token = count($con);

            if($token>0){

                $loga=$this->AdminsMod->seleccion('*', 'Clientes', 'Informacion="'.$con->idCliente.'" ');

                $datas=$this->AdminsMod->select("SELECT a.`idClase`,a.`Clase`,b.`Nombre` NombreCouch,b.`Apellidos` AS ApellidoCouch, YEAR(h.`Fecha`) AS ano, MONTH(h.`Fecha`) AS mes,DAY(h.`Fecha`) AS dia
FROM Clases AS a
INNER JOIN Clientes_Clase AS h ON h.Clase=a.idClase
INNER JOIN Informacion AS b ON b.idInformacion=(SELECT couch.Informacion FROM Couch AS couch WHERE a.Couch=couch.idCouch)
INNER JOIN Categorias AS c ON c.idCategoria=a.Categoria
WHERE h.`Cliente`=".$loga->idCliente."
GROUP BY a.idClase
ORDER BY a.F_inicio ASC");


                $data = array (
                    "status"        => true,
                    "clases" =>$datas
                );

            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data);
    }


    function AddPreferencias(){
        $this->write_log("AddPreferencias","Debug");
        $this->write_log("token:".$this->input->get('token'),"Debug");
        if($this->input->get('token')!=''){

            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" ');
            $token = count($con);

            if($token>0){

                $this->write_log("token:".$this->input->get('token'),"Debug");
                $this->write_log("estatura:".$this->input->post('estatura'),"Debug");
                $this->write_log("sexo:".$this->input->post('sexo'),"Debug");
                $this->write_log("peso:".$this->input->post('peso'),"Debug");
                $this->write_log("nivel:".$this->input->post('nivel'),"Debug");
                $this->write_log("fecha_n:".$this->input->post('fecha_n'),"Debug");
                $this->write_log("cliente:".$this->input->post('cliente'),"Debug");

                $rr=0;
                if(count($this->input->post('ejercicios'))>0){
                    foreach($this->input->post('ejercicios') as $eje){
                        $rr++;
                        $this->write_log("ejercicios:".$rr.$eje,"Debug");
                    }
                }

                $this->write_log(count($con->idCliente),"Debug");
                if(count($con->idCliente)>0){
                    $this->write_log("Ingreso","Debug");

                    $cli = $this->input->post('cliente');
                    $sex = $this->input->post('sexo');
                    $est = $this->input->post('estatura');
                    $pes = $this->input->post('peso');
                    $fec = $this->input->post('fecha_n');
                    $niv = $this->input->post('nivel');
                    $r='';
                    $rr=0;
                    if(count($this->input->post('ejercicios'))>0){
                        foreach($this->input->post('ejercicios') as $eje){
                            $rr++;
                            if($rr>1){
                                $r.=','.$eje;
                            }
                            else
                            {
                                $r.=$eje;
                            }


                        }
                    }

                    $addI = array (
                        'Peso'        => $pes,
                        'Sexo'     => $sex,
                        'Estatura'     => $est,
                        'Fecha_nacimiento'     => $fec,
                        'Nivel'     => $niv,
                        'Ejercicios'     => $r
                    );


                    $log=$this->AdminsMod->editar('Informacion', 'idInformacion',$con->idCliente,$addI);

                    $data = array (
                        "status"        => true,
                        "msg"   =>"Preferencias agregadas con exito"
                    );

                }
                else
                {
                    $this->write_log("No Ingreso","Debug");
                    $data = array (
                        "status"        => false,
                        "msg"   =>"Preferencias no agregadas"
                    );

                }

            }
            else
            {
                $this->write_log("Token no enviado","Token no encontrado");
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }

        }
        else
        {
            $this->write_log("Token no enviado","Debug");

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data);
    }




    function AddMembresia(){

        if($this->input->get('token')!=''){

            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" ');
            $token = count($con);

            if($token>0){

                $this->load->library("conekta/conekta_main");


                try {

                    //creamos un cargo
                    $charge_new = Conekta_Charge::create(array(
                        'amount'      => 2000,
                        'currency'    => 'mxn',
                        'description' => 'Some desc',
                        'details'=> array(
                            'name'=> 'Arnulfo Quimare',
                            'phone'=> '403-342-0642',
                            'email'=> 'logan@x-men.org',
                            'customer'=> array(
                                'logged_in'=> true,
                                'successful_purchases'=> 14,
                                'created_at'=> 1379784950,
                                'updated_at'=> 1379784950,
                                'offline_payments'=> 4,
                                'score'=> 9
                            ),
                            'line_items'=> array(
                                array(
                                    'name'=> 'Box of Cohiba S1s',
                                    'description'=> 'Imported From Mex.',
                                    'unit_price'=> 20000,
                                    'quantity'=> 1,
                                    'sku'=> 'cohb_s1',
                                    'category'=> 'food'
                                )
                            )
                        )
                    ));

                    if($charge_new->status =='paid'){
                        $response['status']=1;
                        $response['charge_id']= $charge_new->id;
                        $response['msg']="Pago existoso";
                    }else{
                        $response['status']=0;
                    }

                } catch (Conekta_Error $e) {
                    $response['status']=0;
                    $response['msg']= $e->getMessage();
                }



                //Regresamos la info ...Cocinado!!
                $json = json_encode($response);
                echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;
                exit;


                if(count($con->idCliente)>0){
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
                        'Cliente'           => $con->idCliente,
                        'Estatus'           => 3,
                        'Recepcion'         => 1,
                        'Nvl'               => 1,
                        'Fecha_registro'    => date('Y-m-d G:i:s'),
                        'Fecha_vencimiento' => $vencimientos
                    );

                    $idC = $this->AdminsMod->agregar('Membrecias', $addT);


                    $data = array (
                        "status"        => true,
                        "msg"   =>"Membresia agregadas con exito"
                    );

                }
                else
                {
                    $this->write_log("No Ingreso","Debug");
                    $data = array (
                        "status"        => false,
                        "msg"   =>"Membresia no agregadas"
                    );

                }

            }
            else
            {
                $this->write_log("Token no enviado","Token no encontrado");
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }

        }
        else
        {
            $this->write_log("Token no enviado","Debug");

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data);
    }

    function GetClases(){

        if($this->input->get('token')!=''){


            $token = count($this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" '));

            if($token>0){
                $i='"';
                $datas=$this->AdminsMod->select("SELECT a.`idClase`,a.`Clase`,concat('http://ws.dctimx.com/Gym/assets/files/',a.`Imagen`) as Imagen,a.`Miembros`,a.`H_inicio`,a.`H_fin`,a.`F_inicio`,a.`F_fin`,a.`Couch`,a.`Estatus`,a.`Fecha_registro`,REPLACE(REPLACE(REPLACE(a.Dias,'$i',''),']',''),'[','') AS Dias,b.`Nombre` NombreCouch,b.`Apellidos` AS ApellidoCouch FROM Clases AS a
INNER JOIN Informacion AS b ON b.idInformacion=(SELECT couch.Informacion FROM Couch AS couch WHERE a.Couch=couch.idCouch)
INNER JOIN Categorias AS c ON c.idCategoria=a.Categoria
GROUP BY a.idClase
ORDER BY a.F_inicio ASC");

                $data = array (
                    "status"        => true,
                    "clases" =>$datas
                );

            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data,JSON_UNESCAPED_SLASHES);

    }



    function GetMisClases(){

        if($this->input->get('token')!=''){


            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" ');
            $token = count($con);


            if($token>0){


                $c = $this->AdminsMod->seleccion('*', 'Clientes', 'idCliente="'.$con->idCliente.'" ');

                if($c!=''){
                    $i='"';
                    $datas=$this->AdminsMod->select("SELECT a.`idClase`,a.`Clase`,concat('http://ws.dctimx.com/Gym/assets/files/',a.Imagen) as Imagen,a.`Miembros`,a.`H_inicio`,a.`H_fin`,a.`F_inicio`,a.`F_fin`,a.`Couch`,a.`Estatus`,a.`Fecha_registro`,REPLACE(REPLACE(REPLACE(a.Dias,'$i',''),']',''),'[','') AS Dias,b.`Nombre` NombreCouch,b.`Apellidos` AS ApellidoCouch FROM Clases AS a
INNER JOIN Informacion AS b ON b.idInformacion=(SELECT couch.Informacion FROM Couch AS couch WHERE a.Couch=couch.idCouch)
INNER JOIN Categorias AS c ON c.idCategoria=a.Categoria
INNER JOIN Clientes_Clase as d on d.Cliente='".$c->Informacion."' and a.idClase=d.Clase
GROUP BY a.idClase
ORDER BY a.F_inicio ASC");



                    $data = array (
                        "status"        => true,
                        "clases" =>$datas
                    );
                }
                else
                {
                    $a=array();
                    $data = array (
                        "status"        => true,
                        "clases"=> $a
                    );
                }

            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data,JSON_UNESCAPED_SLASHES);

    }




    function GetTarifas(){

        if($this->input->get('token')!=''){


            $token = count($this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" '));

            if($token>0){

                $datas=$this->AdminsMod->select("SELECT idTarifa,Nombre,Tipo,Cuota,Descripcion,concat('http://ws.dctimx.com/Gym/assets/files/',Foto) as Foto,Fecha_registro,Estatus from Tarifas");

                $data = array (
                    "status"        => true,
                    "membresias" =>$datas
                );

            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data,JSON_UNESCAPED_SLASHES);

    }


    function ActualizarImg(){

        //$token='5bdvvHS9b148P8sSXYiAy0DMmgNOx4Nt6QPrnyrppln5jGO7vWyUN2wZ89Dw4gP0X';
        $token= $this->input->get('token');
        if($token!=''){


            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$token.'" ');
            $token = count($con);

            if($token>0){


                $datas=$this->AdminsMod->seleccion('idCliente', 'Clientes', 'Informacion="'.$con->idCliente.'" ');

                $config['upload_path'] = './assets/files/';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['encrypt_name'] = true;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')){


                    $upI['Foto'] = $this->upload->data('file_name');


                    $this->AdminsMod->editar('Informacion', 'idInformacion', $con->idCliente, $upI);

                    $data = array (
                        "status"        => true,
                        "msg"=> "Imagen actualizada"
                    );
                }
                else
                {
                    $data = array (
                        "status"        => false,
                        "msg"=> "Imagen no cargada"
                    );
                }




            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data);

    }


    function InscribirClases(){

        if($this->input->get('token')!=''){


            $con=$this->AdminsMod->seleccion('*', 'Session', 'token="'.$this->input->get('token').'" ');
            $token = count($con);

            if($token>0){

                $clase=$this->input->post('clase');

                $datas=$this->AdminsMod->seleccion('idCliente', 'Clientes', 'Informacion="'.$con->idCliente.'" ');

                $addI = array (
                    'Clase'        => $clase,
                    'Cliente'     => $datas->idCliente,
                    'Fecha' => date('Y-m-d G:i:s')
                );

                $datass=$this->AdminsMod->seleccion('*', 'Clientes_Clase', 'Clase="'.$clase.'" and Cliente="'.$datas->idCliente.'" ');

                if(count($datass)>0){
                    $data = array (
                        "status"        => false,
                        "msg"=> "Clase ya registrada"
                    );
                }
                else
                {

                    $id = $this->AdminsMod->agregar('Clientes_Clase', $addI);


                    $add = array (
                        'idClase'        => $clase,
                        'idCliente'     => $datas->idCliente,
                        'Fecha' => date('Y-m-d G:i:s')

                    );

                    $this->AdminsMod->agregar('Estadisticas', $add);




                    $dat=$this->AdminsMod->select("SELECT a.`Miembros` FROM Clases AS a WHERE a.`idClase`=".$clase."");

                    $data = array (
                        "status"        => true,
                        "clases" =>$dat
                    );
                }

            }
            else
            {
                $data = array (
                    "status"        => false,
                    "msg"=> "Token no encontrado"
                );
            }
        }
        else
        {

            $data = array (
                "status"        => false,
                "msg"=> "Token no enviado"
            );

        }

        echo json_encode($data);

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
                'Qr'             => codigo() . '',
                'Sexo'           => $sex
            );

            $id = $this->AdminsMod->agregar('Informacion', $addI);

            $addT = array (
                'Estatus'     => 1,
                'Informacion' => $id
            );

            $idC = $this->AdminsMod->agregar('Clientes', $addT);

            $this->AdminsMod->bitacora('Nuevo Cliente', 'Clientes', $idC);
        }

        redirect("View/ver_/Cliente");

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
            //$upI['Qr'] = codigo() . '';

            if ($this->upload->do_upload('foto')) {

                $upI['Foto'] = $this->upload->data('file_name');
            }

            $this->AdminsMod->editar('Informacion', 'idInformacion', $id, $upI);

            $this->AdminsMod->bitacora('Edicion Cliente', 'Clientes', $id);
        }

        redirect("View/ver_/Cliente");

    }

    function eliminar() {

        $id = $this->input->post('id');

        $this->AdminsMod->editar('Clientes', 'idCliente', $id, array ( 'Estatus' => 2 ));

        $this->AdminsMod->bitacora('Eliminar Cliente', 'Clientes', $id);

    }

    function get_info() {
        $all = $this->AdminsMod->get_info('Clientes');

        foreach ($all as $row) {
            $data['data'][] = array (
                "id"        => $row->idCliente,
                "info"      => $row->Informacion,
                "usuario"   => '<a class="btn btn-default btn-block" href="' . site_url('Qr/generar_qr/' . $row->idCliente) . '"><span class="fa fa-qrcode"> QR <span class="fa fa-download"></span></span></a>',
                "nombre"    => $row->Nombre,
                "apellidos" => $row->Apellidos,
                "foto"      => '<img src="' . archivos($row->Foto) . '" class="img-responsive img-circle" style="max-height: 75px; max-width: 75px">',
                "correo"    => $row->Correo,
                "btn_ed"    => '<a class="btn btn-default btn-block" href="' . site_url('View/nuevo_/Cliente/' . $row->Informacion) . '"><span class="fa fa-edit"></span></a>',
                "btn_el"    => '<button type="button" class="btn btn-danger btn-block" onclick="eliminar(' . $row->idCliente . ')"><span class="fa fa-trash"></span></button>'
            );
        }

        echo json_encode($data);

    }

    function check_telefono() {
        $telf = $this->input->post('tel');
        $id = $this->input->post('id');
        $usu = $this->AdminsMod->seleccion('concat(Nombre," ",Apellidos) as Nombre', 'vwClientes', 'Telefono = "' . $telf . '" and Estatus = 1 and Informacion <> ' . $id);

        if ($usu != null) {
            echo $usu->Nombre;
        } else {
            echo 0;
        }

    }

    function codigo() {
        $this->AdminsMod->editar('Informacion', 'idInformacion', '8', array ( 'Qr' => codigo() . '' ));

    }

}