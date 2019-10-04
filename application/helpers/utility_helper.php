<?php

function assets($url) {
    return 'http://ws.dctimx.com/Gym/assets/' . $url;

}

function archivos($achivo = '') {
    return "http://ws.dctimx.com/Gym/assets/files/" . $achivo;

}

function iniciales($nombre) {
    $notocar = Array ( 'del', 'de' );
    $trozos = explode(' ', $nombre);
    $iniciales = '';
    for ($i = 0; $i < count($trozos); $i++) {
        if (in_array($trozos[$i], $notocar))
            $iniciales .= $trozos[$i] . " ";
        else
            $iniciales .= substr($trozos[$i], 0, 1) . "";
    }
    return $iniciales;

}


function mes($id){
    
    if($id==1){
        $val="Enero";
    }
    if($id==2){
        $val="Febrero";
    }
    if($id==3){
        $val="Marzo";
    }
    if($id==4){
        $val="Abril";
    }
    if($id==5){
        $val="Mayo";
    }
    if($id==6){
        $val="Junio";
    }
    if($id==7){
        $val="Julio";
    }
    if($id==8){
        $val="Agosto";
    }
    if($id==9){
        $val="Septiembre";
    }
    if($id==10){
        $val="Octubre";
    }
    if($id==11){
        $val="Noviembre";
    }
    if($id==12){
        $val="Diciembre";
    }
    
    return $val;
    
}

function codigo() {

    $codigo = "";
    //caracteres a ser utilizados
    $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    //el maximo de caracteres a usar
    $max = strlen($caracteres) - 1;
    //creamos un for para generar el codigo aleatorio utilizando parametros min y max
    for ($i = 0; $i <= 30; $i++) {
        $codigo .= $caracteres[rand(0, $max)];
    }
    //regresamos codigo como valor
    return $codigo;

}



function token() {

    $codigo = "";
    //caracteres a ser utilizados
    $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    //el maximo de caracteres a usar
    $max = strlen($caracteres) - 1;
    //creamos un for para generar el codigo aleatorio utilizando parametros min y max
    for ($i = 0; $i <= 64; $i++) {
        $codigo .= $caracteres[rand(0, $max)];
    }
    //regresamos codigo como valor
    return $codigo;

}


function fecha_texto($date, $op) {

    switch (date('N', strtotime($date))) {
        case 1:
            $d = 'Lunes';
            break;
        case 2:
            $d = 'Martes';
            break;
        case 3:
            $d = 'Miercoles';
            break;
        case 4:
            $d = 'Jueves';
            break;
        case 5:
            $d = 'Viernes';
            break;
        case 6:
            $d = 'Sabado';
            break;
        case 7:
            $d = 'Domingo';
            break;
    }

    switch (date('n', strtotime($date))) {
        case 1:
            $m = 'Enero';
            break;
        case 2:
            $m = 'Febrero';
            break;
        case 3:
            $m = 'Marzo';
            break;
        case 4:
            $m = 'Abril';
            break;
        case 5:
            $m = 'Mayo';
            break;
        case 6:
            $m = 'Junio';
            break;
        case 7:
            $m = 'Julio';
            break;
        case 8:
            $m = 'Agosto';
            break;
        case 9:
            $m = 'Septiembre';
            break;
        case 10:
            $m = 'Octubre';
            break;
        case 11:
            $m = 'Noviembre';
            break;
        case 12:
            $m = 'Diciembre';
            break;
    }
    $fecha = date('d', strtotime($date));
    $ano = date('Y', strtotime($date));

    $tiempo = date('G:m:s', strtotime($date));

    switch ($op) {
        case 'h':
            return $tiempo;
        case 'f':
            return $d . ' ' . $fecha . ' de ' . $m . ' del ' . $ano;
        case 'n':
            return $fecha . '/' . $m . '/' . $ano;
    }

}
