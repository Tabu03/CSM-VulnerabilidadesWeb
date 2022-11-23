<?php

$bd;
$permitirInstancianueva;
$cadenaConexion = 'mysql:dbname=gnb;host=127.0.0.1';
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
        foreach ($result as $level){
            $_SESSION["LEVEL"]=$level["LEVEL"];
        }
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

function insertar($cadenaConexion, $usuario, $password){
	try{
		$bd=new PDO($cadenaConexion, $usuaio, $pass);
		$insert="insert into users values (ID,'$user', sha1('$passwd'), $level, $saldo)";
		$result=$bd->query($insert);

		if($result){
			echo "Se ha insertado correctamente";
			echo "Fila (s) insertadas: ".$result->rowCount()."<br>";
		} else {
			print_r($bd->errorinfo());
		}
		
		echo "Codigo insertado: ".($bd->lastInsertId()."<br>");
		$bd=null;
	}
    catch (Exception $e){
        echo "Fallo al conectar con la base de datos";
    }
}

function borrar($cadenaConexion, $usuario, $password){
	try{
		$bd=new PDO($cadenaConexion, $usuaio, $pass);
		$delete="delete from users where id=$id";
		$result=$bd->query($delete);

		if($result){
			echo "Se ha borrado correctamente";
			echo "Fila (s) borradas: ".$result->rowCount()."<br>";
		} else {
			print_r($bd->errorinfo());
		}
		$bd=null;
	}
        catch (Exception $e){
        echo "Fallo al conectar con la base de datos";
    }
}

function modificar($cadenaConexion, $usuario, $password){
	try{
		$bd=new PDO($cadenaConexion, $usuaio, $pass);
		$update="update users set saldo=saldo-$saldo where ID=2";
		$result=$bd->query($update);

		if($result){
			echo "Se ha modificado correctamente";
			echo "Fila (s) actualizadas: ".$result->rowCount()."<br>";
		} else {
			print_r($bd->errorinfo());
		}
		$bd=null;
	}
        catch (Exception $e){
        echo "Fallo al conectar con la base de datos";
    }
}
