<?php

$bd;
$permitirInstancianueva;
$cadenaConexion = 'mysql:dbname=proyecto;host=127.0.0.1';
$usuario = filter_input(INPUT_POST, "usuario");
$pass = filter_input(INPUT_POST, "clave");
$c = 0;

function consulta($consulta, $cadenaConexion, $usuario, $pass) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = $consulta;
    $result = $bd->query($ins);
    foreach ($result as $resultado) {
        session_start();
    }
    return $result;
}

$consulta = consulta('select * from users where PASSWORD = sha1("'.$pass.'")&&USER="'.$usuario.'";', $cadenaConexion, $usuario, $pass);
