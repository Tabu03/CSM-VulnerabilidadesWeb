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


function consulta($consulta){
    $ins="$consulta";
    $result = $bd->query($ins);
}


/*require 'vendor/autoload.php';
try{
    $cliente= new MongoDB\Client("mongodb://localhost:27017");
    $bd = $cliente->libroservidor;
    
    //Se elimina el usuario llamado 'Paco'
    $updateResult = $bd->usuarios->deleteOne(
            ['nombre'=>'Pablo']
    );
    
    echo "Documentos restantes después de borrar ".$bd->usuarios->count();
    
} catch (Exception $ex) {
    print ($ex);
}*/