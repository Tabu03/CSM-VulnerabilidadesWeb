<?php
/**
 * Base de datos a la que nos conectamos en todas las funciones 
 * esta declarada aqui de forma que no se comentara en los 
 * comentarios individuales
 */
$cadenaConexion = 'mysql:dbname=gnb;host=127.0.0.1';

/**
 * Funcion inicioSesion(cadena de conexion)
 * conecta a la base de datos y comprueba, si la consulta devuelve alguna
 * fila, significa que encontro el usuario y la contraseña, por lo tanto
 * la sesion comienza
 * @param type $cadenaConexion
 */
function inicioSesion($cadenaConexion) {
    $usuario = filter_input(INPUT_POST, "usuario");
    $pass = filter_input(INPUT_POST, "clave");
    $bd = new PDO($cadenaConexion, "root", "");
    $ins=$bd->prepare("select * from users where PASSWORD = sha1(?)&&USER=?");
    $ins->execute(array($pass,$usuario));
    
    if($ins->rowCount()===1) {
        $_SESSION["user"]=$usuario;
        foreach ($ins as $level){
            $_SESSION["LEVEL"]=$level["LEVEL"];
        }
    }
}
/**
 * 
 * @param type $cadenaConexion
 */
function addCliente($cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = 'select * from users';
    $result = $bd->query($ins);
    echo "<table class='table'>";
    if($_COOKIE["language"]==0){
    echo "<tr class='table__head'>
            <td>ID_Cliente</td>
            <td>Nombre_Cliente</td>
            <td>Saldo</td>
        </tr>";
    }
    else{
        echo "<tr class='table__head'>
            <td>ID_Client</td>
            <td>Client_Name</td>
            <td>Balance</td>
        </tr>";
    }
    foreach ($result as $fila){
        echo "<tr class='table__cont'><td>".$fila["ID"]."</td><td>".$fila["USER"]."</td><td>".$fila["SALDO"]."</td></tr>";
    }
    echo "</table>";
}

/**
 * 
 * @param type $cadenaConexion
 */
function transacciones($cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = 'select * from moves';
    $result = $bd->query($ins);
    echo "<table class='table'>";
    if($_COOKIE["language"]==0){
    echo '<tr class="table__head">
            <td>ID_Transacción</td>
            <td>ID_Cliente</td>
            <td>Saldo modificado</td>
            <td>Fecha</td>
            <td>Descripción</td>
        </tr>';
    }else{
        echo '<tr class="table__head">
            <td>ID_Transaction</td>
            <td>ID_Client</td>
            <td>Account balance</td>
            <td>Date</td>
            <td>Description</td>
        </tr>';
    }
    foreach ($result as $fila){
        echo "<tr class='table__cont'><td>".$fila["ID_TRANS"]."</td><td>".$fila["USER_ID"]."</td><td>".
                $fila["CANTIDAD"]."</td><td>".
                $fila["FECHA"]."</td><td>".
                $fila["MESSAGE"]."</td></tr>";
    }
    echo "</table>";
}
/**
 * Se guardan los campos del POST en el array campos, conecta a la base de datos, prepara
 * la consulta de la cual no sabemos el nombre del usuario a crea y la ejecutamos con el 
 * primer campo que es el usuario, si el usuario no existe, es decir que la consulta devuelve
 * 0 filas, se inserta en la base de datos con los valores del array $campos.
 * @param type $cadenaConexion
 */
function insertar($cadenaConexion){
	$campos=[filter_input(INPUT_POST, "usuario"),
            filter_input(INPUT_POST, "pass"),
            filter_input(INPUT_POST, "level"),
            filter_input(INPUT_POST, "balance")];
        if($campos[3]==""&&$campos[2]==1){
            $campos[3]=null;
        }
        try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where user=?");
                $select->execute(array($campos[0]));
                
                if ($select->rowCount()==0){
                    $insert=$bd->prepare("insert into users values(ID,?, sha1(?), ?, ?)");
                    $insert->execute(array($campos[0],$campos[1],$campos[2],$campos[3]));
                }
		
		$bd=null;
	}
    catch (Exception $e){
        
    }
}
/**
 * Se inicia la conexión a la base de datos, comprobamos que el user existe, si 
 * existe, es decir las filas que devuelve son mayores que 0, entonces lo borramos, 
 * solo si es un usuario común, es decir su level es 2.
 * @param type $cadenaConexion
 */
function borrar($cadenaConexion){
	try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where id=?");
                $select->execute(array(filter_input(INPUT_POST, "usuarioID")));
                if($select->rowCount()>0){
                    foreach ($select as $fila){
                        if ($fila["LEVEL"]==2){
                            $delete=$bd->prepare("delete from users where id=?");
                            $delete->execute(array(filter_input(INPUT_POST, "usuarioID")));
                        }
                    }
                    
                }
		$bd=null;
	}
        catch (Exception $e){
            
    }
}
/**
 * Se guardan los campos del post en el array $post y se inicia la conexión 
 * a la base de datos, comprobamos que el user existe, si existe, es decir 
 * las filas que devuelve son mayores que 0, entonces lo actualizamos con 
 * el nuevo saldo, usando el id del usuario para identificarlo.
 * @param type $cadenaConexion
 */
function modificar($cadenaConexion){
    $post=[filter_input(INPUT_POST, "saldo"),
        filter_input(INPUT_POST, "usuarioID")];
    try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where id=?");
                $select->execute(array($post[1]));
                if($select->rowCount()>0){
                    $update=$bd->prepare("update users set saldo=? where ID=?");
                   
                    $update->execute(array($post[0],$post[1]));
                    $bd->commit();
                }
		$bd=null;
	}
        catch (Exception $e){
            
    }
}
/**
 * Primero cogemos el nombre del usuario de la sesión y el saldo introducido en el formulario.
 * Conectamos y preparamos la consulta para sacar la id del usuario y el saldo actual.
 * Nos tiene que devolver una fila, si nos devuelve algo, por lo tanto guardamos en saldoActual el saldo actual y en id el id del cliente
 * Si el saldo que queremos sacar es mayor que el actual no realiza el update, si no lo realiza e inserta en moves la operacion realizada
 * @param type $cadenaConexion
 */
function sacarDinero($cadenaConexion){
    $post=[$_SESSION["user"],
        filter_input(INPUT_POST, "saldo")];
    
    $saldoActual=0;
    $id;
    
    $bd=new PDO($cadenaConexion, "root", "");
    $result=$bd->prepare("select * from users where user=?");
    $result->execute(array($post[0]));
    if ($result->rowCount()==1){
        foreach($result as $saldo){
            $saldoActual=$saldo["SALDO"];
            $id=$saldo["ID"];
        }
        if (($saldoActual-$post[1])>=0){
            $select=$bd->prepare("update users set saldo=saldo-? where user=?");
            $select->execute(array($post[1],$post[0]));
            $select=$bd->prepare("insert into moves values(ID_TRANS,?,-?,DATE(NOW()),'Retirada de dinero')");
            $select->execute(array($id,$post[1]));
        }
    }
}


/**
 * Primero cogemos el nombre del usuario de la sesión y el saldo introducido en el formulario.
 * Conectamos y preparamos la consulta para sacar la id del usuario y el saldo actual.
 * Os tiene que devolver una fila, si nos devuelve algo, por lo tanto guardamos en saldoActual el saldo actual y en id el id del cliente.
 * Sumamos la cantidad a ingresar al saldo actual.
 * @param type $cadenaConexion
 */
function ingresarDinero($cadenaConexion){
    $post=[$_SESSION["user"],
        filter_input(INPUT_POST, "saldo")];
    $id;
    
    $bd=new PDO($cadenaConexion, "root", "");
    $result=$bd->prepare("select * from users where user=?");
    $result->execute(array($post[0]));
    if ($result->rowCount()==1){
        foreach($result as $saldo){
            $id=$saldo["ID"];
        }
            $select=$bd->prepare("update users set saldo=saldo+? where user=?");
            $select->execute(array($post[1],$post[0]));
            $select=$bd->prepare("insert into moves values(ID_TRANS,?,?,DATE(NOW()),'Ingreso de dinero')");
            $select->execute(array($id,$post[1]));
        
    }
}
/**
 * Muestra de foma permanete el saldo actual de la cuenta del usuario basandonos
 * en el nombre de usuario
 * @param type $cadenaConexion
 * @return type
 */
function saldoActual($cadenaConexion){
    $user=$_SESSION["user"];
    $bd=new PDO($cadenaConexion, "root", "");
    $result=$bd->prepare("select * from users where user=?");
    $result->execute(array($user));
    if ($result->rowCount()==1){
        foreach($result as $saldo){
            return $saldo["SALDO"];
        }
    }
}