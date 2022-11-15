<?php

$bd;
$permitirInstancianueva;
$cadenaConexion = 'mysql:dbname=proyecto;host=127.0.0.1';
$usuario = filter_input(INPUT_POST, "usuario");
$pass = filter_input(INPUT_POST, "clave");


/*
 * funcion inicioSesion(consulta,cadena de conexion, usuario, pass)
 * conecta a la base de datos y comprueba, si la consulta devuelve alguna
 * fila, significa que encontro el usuario y la contraseña, por lo tanto
 * la sesion comienza
 * 
 */
function inicioSesion($consulta, $cadenaConexion, $usuario, $pass) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = $consulta;
    $result = $bd->query($ins);
    if($result->rowCount()===1) {
        session_start();
        $_SESSION["user"]=$usuario;
    }
}

function addCliente($consulta, $cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = $consulta;
    $result = $bd->query($ins);
    
}

function sesion(){
    if(isset($_SESSION["user"])){
        header ("Location:./pages/inicio.php");
    }
}


echo "<table class='table'>";
    foreach ($result as $fila){
        echo "<tr><td>".$fila["ID"]."</td><td>".$fila["USER"]."</td><td>".$fila["SALDO"]."</td></tr>";
    }
    echo "</table>";
