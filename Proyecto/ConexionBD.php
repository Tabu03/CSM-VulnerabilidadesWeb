<?php
$bd;
$permitirInstancianueva;
$cadenaConexion = 'mysql:proyecto=proyecto;host=127.0.0.1';
$usuario = filter_input(INPUT_POST, "usuario");
$pass = filter_input(INPUT_POST, "clave");

function conectarBD($cadenaConexion, $usuario, $pass) {
    try {
        $bd = new PDO($cadenaConexion, $usuario, $pass);
        return $bd;
    } catch (Exception $ex) {
        echo "Contraseña incorrecta";
    }
}

$bd=conectarBD($cadenaConexion, $usuario, $pass);

