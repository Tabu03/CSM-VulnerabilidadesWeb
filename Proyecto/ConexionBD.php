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
        $_SESSION["user"]=$usuario;
    }
}

function addCliente($consulta, $cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = $consulta;
    $result = $bd->query($ins);
    echo "<table class='table'>";
    echo "<tr class='table__head'>
            <td>ID_Cliente</td>
            <td>Nombre_Cliente</td>
            <td>Saldo</td>
        </tr>";
    foreach ($result as $fila){
        echo "<tr class='table__cont'><td>".$fila["ID"]."</td><td>".$fila["USER"]."</td><td>".$fila["SALDO"]."</td></tr>";
    }
    echo "</table>";
}
/*
function sesion(){
    if(isset($_SESSION["user"])){
        header ("Location:./pages/movimientos.php");
    }
}
*/
/*

*/